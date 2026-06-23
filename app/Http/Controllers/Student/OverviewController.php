<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnnualReport;
use App\Models\BranchOrgChart;
use App\Models\Event;
use App\Models\StudentEventBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OverviewController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($branch, 403, 'You are not assigned to a branch.');

        // ── Stats ──────────────────────────────────────────────────────────────
        // Members come from the manually-tracked membership snapshot (latest month),
        // falling back to the branch account count if none has been recorded.
        $latestSnapshot = $branch->membershipSnapshots()->latest('as_of')->first();
        $totalMembers   = $latestSnapshot?->member_count ?? $branch->members()->count();
        $membersAsOf    = $latestSnapshot?->as_of?->format('M Y');

        $totalEvents     = $branch->events()->count();
        $sdgEvents       = $branch->events()->where('is_sdg', true)->count();
        $publishedEvents = $branch->events()->where('track_published', true)->count();

        $budgetPending   = StudentEventBudget::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->where('status', 'pending')->count();

        // ── Upcoming events (max 5 for the table) ─────────────────────────────
        $upcomingEvents = Event::forBranch($branch->id)
            ->whereIn('status', ['open', 'approved'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->with('registrations')
            ->take(5)
            ->get();

        // ── Recent budget requests (max 5) ────────────────────────────────────
        $recentBudgets = StudentEventBudget::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->with('event')
            ->latest()
            ->take(5)
            ->get();

        // ── Needs Attention — items requiring the chapter to act / awaiting HQ ──
        $attention = collect();

        Event::forBranch($branch->id)->where('status', 'submitted')->latest()->get()
            ->each(fn ($e) => $attention->push(['title' => $e->title, 'tag' => 'Event', 'meta' => 'Awaiting HQ review', 'tone' => 'review', 'url' => route('student.events')]));

        Event::forBranch($branch->id)
            ->where(fn ($q) => $q->where('status', 'rejected')->orWhere(fn ($q2) => $q2->where('status', 'draft')->whereNotNull('revision_note')))
            ->latest()->get()
            ->each(fn ($e) => $attention->push(['title' => $e->title, 'tag' => 'Event', 'meta' => 'Needs revision', 'tone' => 'action', 'url' => route('student.events')]));

        StudentEventBudget::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->with('event')->withCount('receipts')->latest()->get()
            ->each(function ($b) use ($attention) {
                $t = $b->event?->title ?? 'Budget request';
                $item = match (true) {
                    $b->status === 'pending'  => ['meta' => 'Awaiting HQ review',     'tone' => 'review'],
                    $b->status === 'rejected' => ['meta' => 'Returned — reinstate',   'tone' => 'action'],
                    $b->status === 'draft'    => ['meta' => 'Draft — resubmit',       'tone' => 'action'],
                    $b->status === 'approved' && !$b->reimbursed_at && $b->receipts_count === 0
                                              => ['meta' => 'Submit invoices',        'tone' => 'action'],
                    default                   => null,
                };
                if ($item) $attention->push($item + ['title' => $t, 'tag' => 'Budget', 'url' => route('student.budget')]);
            });

        AnnualReport::where('branch_id', $branch->id)->where('status', 'rejected')->latest()->get()
            ->each(fn ($r) => $attention->push(['title' => $r->title, 'tag' => 'Report', 'meta' => 'Returned — resubmit', 'tone' => 'action', 'url' => route('student.reports')]));

        // A returned org chart needs the chapter to re-upload.
        $returnedChart = BranchOrgChart::where('branch_id', $branch->id)
            ->where('is_current', true)->where('status', 'rejected')->first();
        if ($returnedChart) {
            $attention->push(['title' => 'Organisation chart', 'tag' => 'Report', 'meta' => 'Returned — re-upload', 'tone' => 'action', 'url' => route('student.overview') . '#org-chart']);
        }

        // Chapter-action items first, then awaiting-HQ.
        $attention = $attention->sortBy(fn ($i) => $i['tone'] === 'action' ? 0 : 1)->take(8)->values();

        // ── Organisation chart — one chart per academic year, browsable by year ─
        $allCharts    = BranchOrgChart::where('branch_id', $branch->id)->get();
        $chartsByYear = $allCharts->keyBy('academic_year');
        $currentChart = $allCharts->firstWhere('is_current', true);
        $orgChartRequestedAt = $branch->org_chart_requested_at;

        // The year list = uploadable years (prev/current/next) + any year that has a chart.
        $startYear   = (int) substr((string) ($branch->academic_year ?? now()->year), 0, 4);
        $uploadYears = [];
        for ($i = -1; $i <= 1; $i++) {
            $s = $startYear + $i;
            $uploadYears[] = $s . '/' . ($s + 1);
        }
        $orgYears = collect($uploadYears)
            ->merge($chartsByYear->keys())
            ->unique()->sortDesc()->values()->all();

        $orgDefaultYear = $currentChart?->academic_year
            ?? ($branch->academic_year ?: ($uploadYears[1] ?? ($orgYears[0] ?? null)));

        return view('student-section.overview', compact(
            'user', 'branch',
            'totalMembers', 'membersAsOf',
            'totalEvents', 'sdgEvents', 'publishedEvents', 'budgetPending',
            'upcomingEvents', 'recentBudgets', 'attention',
            'currentChart', 'chartsByYear', 'orgYears', 'orgDefaultYear', 'orgChartRequestedAt'
        ));
    }

    /**
     * Upload / replace the branch organisation chart.
     */
    public function uploadOrgChart(Request $request)
    {
        $validated = $request->validate([
            'org_chart'     => 'required|file|mimes:png,jpg,jpeg,pdf|max:10240',
            'academic_year' => 'required|string|max:20',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($user->isBranchAdmin(), 403);

        $year     = $validated['academic_year'];
        $existing = BranchOrgChart::where('branch_id', $branch->id)->where('academic_year', $year)->first();

        // Once HQ approves a year's chart it is locked — it can't be replaced.
        if ($existing && $existing->status === 'approved') {
            return back()->with('error', "The {$year} organisation chart is approved and can no longer be replaced.");
        }

        $path = $request->file('org_chart')->store("branches/{$branch->id}/org-chart", 'public');

        // One chart per academic year (history preserved); only the latest is current.
        BranchOrgChart::where('branch_id', $branch->id)->update(['is_current' => false]);

        if ($existing && $existing->file_path && $existing->file_path !== $path) {
            Storage::disk('public')->delete($existing->file_path);
        }

        // Uploading / replacing puts the chart back Under Review and clears the prior decision.
        BranchOrgChart::updateOrCreate(
            ['branch_id' => $branch->id, 'academic_year' => $year],
            [
                'file_path'      => $path,
                'is_current'     => true,
                'status'         => 'pending',
                'review_comment' => null,
                'reviewed_at'    => null,
                'reviewed_by'    => null,
                'uploaded_by'    => $user->id,
            ]
        );

        $branch->update(['org_chart_path' => $path]);

        ActivityLog::record(
            $branch->id,
            'orgchart_submitted',
            "Organisation chart submitted for review ({$year})",
            $user->id,
            $branch
        );

        return back()->with('success', 'Organisation chart submitted for HQ review.');
    }

    /**
     * Remove a year's organisation chart (defaults to the current one).
     */
    public function removeOrgChart(Request $request)
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($user->isBranchAdmin(), 403);

        $year  = $request->input('academic_year');
        $chart = BranchOrgChart::where('branch_id', $branch->id)
            ->when($year, fn ($q) => $q->where('academic_year', $year), fn ($q) => $q->where('is_current', true))
            ->latest('id')->first();

        // An approved chart is locked — it can't be removed.
        if ($chart && $chart->status === 'approved') {
            return back()->with('error', 'An approved organisation chart cannot be removed.');
        }

        if ($chart) {
            $wasCurrent = $chart->is_current;
            if ($chart->file_path) {
                Storage::disk('public')->delete($chart->file_path);
            }
            $chart->delete();

            if ($wasCurrent) {
                $branch->update(['org_chart_path' => null]);
            }
        }

        return back()->with('success', 'Organisation chart removed.');
    }
}