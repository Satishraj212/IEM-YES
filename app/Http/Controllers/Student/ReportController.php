<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnnualReport;
use App\Models\Branch;
use App\Models\BranchMembershipSnapshot;
use App\Models\Event;
use App\Models\StudentEventBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        $analytics = $this->analytics($branch);

        $annualReports = AnnualReport::where('branch_id', $branch->id)
            ->orderByDesc('year')
            ->get();

        return view('student-section.reports', array_merge($analytics, compact(
            'user', 'branch', 'annualReports'
        )));
    }

    /**
     * The branch's tracked analytics — the single source the dashboard renders and
     * the annual report snapshots. Attendance/contributor metrics are intentionally
     * excluded (not tracked); membership growth is recorded manually.
     */
    private function analytics(Branch $branch): array
    {
        $totalEvents  = Event::forBranch($branch->id)->count();
        $sdgEvents    = Event::forBranch($branch->id)->where('is_sdg', true)->count();
        $totalMembers = $branch->members()->count();

        $byCategory = Event::forBranch($branch->id)
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->category => (int) $r->count])
            ->toArray();

        $sdgBreakdown = Event::forBranch($branch->id)
            ->where('is_sdg', true)
            ->whereNotNull('sdg_goals')
            ->get()
            ->flatMap(fn ($e) => $e->sdg_goals ?? [])
            ->countBy()
            ->sortKeys()
            ->toArray();

        // Manually-recorded membership growth (chapter adds a month + count).
        $membershipGrowth = $branch->membershipSnapshots
            ->map(fn ($s) => [
                'label'        => $s->label,
                'member_count' => $s->member_count,
                'new_members'  => $s->new_members,
            ])
            ->values()
            ->toArray();

        // ── Events pipeline (meeting-ready counters) ───────────────────────────
        $eventStatuses = Event::forBranch($branch->id)
            ->select('status', DB::raw('count(*) as c'))
            ->groupBy('status')
            ->pluck('c', 'status');

        $eventsSummary = [
            'total'     => $totalEvents,
            'approved'  => (int) ($eventStatuses['approved'] ?? 0),
            'submitted' => (int) ($eventStatuses['submitted'] ?? 0),
            'draft'     => (int) ($eventStatuses['draft'] ?? 0),
            'rejected'  => (int) ($eventStatuses['rejected'] ?? 0),
            'published' => Event::forBranch($branch->id)->where('track_published', true)->count(),
            // Past events held this year (start date already passed).
            'past'      => Event::forBranch($branch->id)
                                ->whereYear('start_date', now()->year)
                                ->whereDate('start_date', '<', now())
                                ->count(),
            'sdg'       => $sdgEvents,
        ];

        // ── Budget summary (across the branch's events) ────────────────────────
        $bq        = StudentEventBudget::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))->get();
        $approvedBq = $bq->where('status', 'approved');

        $budgetSummary = [
            'requests'   => $bq->count(),
            'requested'  => (float) $bq->sum('total_requested'),
            'approved'   => (float) $approvedBq->sum('total_approved'),
            'reimbursed' => (float) $approvedBq->sum('total_reimbursed'),
            'pending'    => $bq->where('status', 'pending')->count(),
            'rejected'   => $bq->where('status', 'rejected')->count(),
        ];
        $budgetSummary['unused'] = round($budgetSummary['approved'] - $budgetSummary['reimbursed'], 2);

        return compact(
            'totalEvents', 'sdgEvents', 'totalMembers',
            'byCategory', 'sdgBreakdown', 'membershipGrowth',
            'eventsSummary', 'budgetSummary'
        );
    }

    /**
     * A full snapshot (analytics + meta) used for the generated annual report.
     */
    private function snapshot(Branch $branch): array
    {
        return array_merge($this->analytics($branch), [
            'meta' => [
                'branch'        => $branch->identity_name ?? $branch->name,
                'institution'   => $branch->institution,
                'academic_year' => $branch->academic_year,
                'generated_at'  => now()->toDateTimeString(),
            ],
        ]);
    }

    /**
     * Record a manual membership snapshot for a month.
     */
    public function storeMembership(Request $request)
    {
        $validated = $request->validate([
            'as_of'        => 'required|date',
            'member_count' => 'required|integer|min:0',
            'new_members'  => 'nullable|integer',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($user->isBranchAdmin(), 403);

        // Normalise to the first of the month so one entry exists per month.
        $asOf = \Carbon\Carbon::parse($validated['as_of'])->startOfMonth()->toDateString();

        BranchMembershipSnapshot::updateOrCreate(
            ['branch_id' => $branch->id, 'as_of' => $asOf],
            [
                'member_count' => $validated['member_count'],
                'new_members'  => $validated['new_members'] ?? null,
                'recorded_by'  => $user->id,
            ]
        );

        return back()->with('success', 'Membership figure recorded.');
    }

    /**
     * Generate the annual report from the branch's tracked analytics and submit it
     * to HQ. Also handles resubmitting a returned (rejected) report.
     */
    public function submit()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($user->isBranchAdmin(), 403);

        $year     = now()->year;
        $existing = AnnualReport::where('branch_id', $branch->id)->where('year', $year)->first();

        // Block double-submission while it's already with HQ or already approved.
        if ($existing && in_array($existing->status, ['pending', 'approved'])) {
            return back()->with('error', "This year's report is already " . $existing->status . '.');
        }

        $report = AnnualReport::updateOrCreate(
            ['branch_id' => $branch->id, 'year' => $year],
            [
                'submitted_by' => $user->id,
                'title'        => ($branch->identity_name ?? $branch->name) . " Annual Report {$year}",
                'report_data'  => $this->snapshot($branch),   // fresh snapshot at submit time
                'status'       => 'pending',
                'submitted_at' => now(),
                'notes'        => null,
                'reviewed_by'  => null,
                'reviewed_at'  => null,
            ]
        );

        ActivityLog::record(
            $branch->id,
            'report_submitted',
            ($existing ? 'Annual report resubmitted for ' : 'Annual report submitted for ') . $year,
            $user->id,
            $report
        );

        return back()->with('success', 'Annual report generated and submitted to HQ for review.');
    }

    /**
     * Print-friendly live report (current analytics) — the chapter saves this as PDF.
     */
    public function preview()
    {
        /** @var \App\Models\User $user */
        $branch = Auth::user()->branch;

        return view('student-section.report-document', [
            'd'    => $this->snapshot($branch),
            'back' => route('student.reports'),
        ]);
    }

    /**
     * Print-friendly view of a specific submitted report's stored snapshot.
     */
    public function document(AnnualReport $report)
    {
        /** @var \App\Models\User $user */
        $branch = Auth::user()->branch;
        abort_unless($report->branch_id === $branch->id, 403);

        $data = $report->report_data ?: $this->snapshot($branch);
        $data['meta']['report_year']   = $report->year;
        $data['meta']['report_status'] = $report->status;

        return view('student-section.report-document', [
            'd'    => $data,
            'back' => route('student.reports'),
        ]);
    }

    /**
     * Generate and stream a CSV summary of the branch's events.
     */
    public function download()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        $events = Event::forBranch($branch->id)
            ->with('budget')
            ->orderBy('start_date')
            ->get();

        $filename = 'branch-report-' . str_replace(' ', '-', strtolower($branch->name)) . '-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($events, $branch) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['YES IEM Branch Report — ' . $branch->name]);
            fputcsv($handle, ['Generated: ' . now()->format('j F Y')]);
            fputcsv($handle, []);
            fputcsv($handle, ['#', 'Title', 'Category', 'Status', 'Start Date', 'End Date', 'Venue', 'SDG', 'Budget Requested (RM)', 'Budget Status']);

            foreach ($events as $i => $event) {
                fputcsv($handle, [
                    $i + 1,
                    $event->title,
                    $event->category,
                    $event->status,
                    $event->start_date?->format('j M Y') ?? '',
                    $event->end_date?->format('j M Y') ?? '',
                    $event->venue ?? '',
                    $event->is_sdg ? 'Yes' : 'No',
                    $event->budget?->total_requested ?? '',
                    $event->budget?->status ?? '',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
