<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Branch;
use App\Models\BranchOrgChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /** The three states YES chapters are organised under, with accordion dot colours. */
    const STATE_COLOURS = [
        'Selangor'     => '#5b21b6',
        'Kuala Lumpur' => '#003366',
        'Putrajaya'    => '#c8a84b',
    ];

    public function index()
    {
        // Only real student chapters, with their org-chart submissions per year
        $chapters = Branch::chapters()
            ->withCount('members')
            ->with(['orgCharts' => fn ($q) => $q->orderByDesc('academic_year')])
            ->orderBy('name')
            ->get();

        // Group into state accordions
        $states = $chapters
            ->groupBy('state')
            ->map(function ($group, $state) {
                return [
                    'name'     => $state,
                    'color'    => self::STATE_COLOURS[$state] ?? '#6b7280',
                    'chapters' => $group->map(fn ($b) => $this->formatChapter($b))->values(),
                    'students' => $group->sum(fn ($b) => $b->member_count ?: $b->members_count),
                ];
            })
            ->sortByDesc(fn ($s) => count($s['chapters']))
            ->values();

        $totalChapters = $chapters->count();
        $totalStudents = $chapters->sum(fn ($b) => $b->member_count ?: $b->members_count);
        $pendingCharts = BranchOrgChart::where('status', 'pending')->count();

        return view('admin.branches', [
            'states'        => $states,
            'totalChapters' => $totalChapters,
            'totalStudents' => $totalStudents,
            'pendingCharts' => $pendingCharts,
            'stateOptions'  => array_keys(self::STATE_COLOURS),
            'pageTitle'     => 'Chapters',
            'pageSubtitle'  => 'State Branches',
            'pageDesc'      => 'Student chapter org-chart management',
        ]);
    }

    private function formatChapter(Branch $b): array
    {
        return [
            'id'            => $b->id,
            'name'          => $b->institution ?: $b->name,
            'abbr'          => $b->name,
            'code'          => $b->code,
            'location'      => $b->location,
            'academic_year' => $b->academic_year,
            'members'       => $b->member_count ?: $b->members_count,
            'requested_at'  => $b->org_chart_requested_at?->format('j M Y'),
            'org_charts'    => $b->orgCharts->map(fn ($oc) => [
                'id'             => $oc->id,
                'academic_year'  => $oc->academic_year,
                'status'         => $oc->status,
                'url'            => $oc->url,
                'comment'        => $oc->review_comment,
                'reviewed_at'    => $oc->reviewed_at?->format('j M Y'),
            ])->values(),
        ];
    }

    /** Ask a chapter to upload its org chart. */
    public function requestOrgChart(Branch $branch)
    {
        $branch->update(['org_chart_requested_at' => now()]);

        ActivityLog::record(
            $branch->id,
            'orgchart_requested',
            "Org chart upload requested from {$branch->name}",
            Auth::id(),
            $branch
        );

        return response()->json([
            'success'      => true,
            'requested_at' => $branch->org_chart_requested_at->format('j M Y'),
        ]);
    }

    /** Approve or reject a specific year's org chart, with an optional comment. */
    public function reviewOrgChart(Request $request, BranchOrgChart $orgChart)
    {
        $data = $request->validate([
            'decision' => 'required|in:approved,rejected',
            'comment'  => 'nullable|string|max:1000',
        ]);

        $orgChart->update([
            'status'         => $data['decision'],
            'review_comment' => $data['comment'] ?? null,
            'reviewed_at'    => now(),
            'reviewed_by'    => Auth::id(),
            // The reviewed chart stays the chapter's current one (so a returned chart
            // surfaces on their dashboard for re-upload); approval just supersedes others.
        ]);

        if ($data['decision'] === 'approved') {
            BranchOrgChart::where('branch_id', $orgChart->branch_id)
                ->where('id', '!=', $orgChart->id)
                ->update(['is_current' => false]);
        }

        $branch = $orgChart->branch;
        ActivityLog::record(
            $branch->id,
            $data['decision'] === 'approved' ? 'orgchart_approved' : 'orgchart_rejected',
            "Org chart {$data['decision']} for {$branch->name} ({$orgChart->academic_year})",
            Auth::id(),
            $orgChart,
            $data['comment'] ?? ''
        );

        return response()->json([
            'success'     => true,
            'status'      => $orgChart->status,
            'comment'     => $orgChart->review_comment,
            'reviewed_at' => $orgChart->reviewed_at->format('j M Y'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:20|unique:branches,code',
            'institution'   => 'required|string|max:255',
            'state'         => 'required|in:' . implode(',', array_keys(self::STATE_COLOURS)),
            'location'      => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:20',
            'member_count'  => 'nullable|integer|min:0',
            'status'        => 'required|in:active,inactive,suspended',
        ], [
            'code.unique' => 'That chapter code is already taken.',
            'state.in'    => 'Pick one of the three YES states.',
        ]);

        $branch = Branch::create($validated);

        ActivityLog::record($branch->id, 'chapter_created', "Student chapter created: {$branch->name}", Auth::id(), $branch);

        $branch->loadCount('members')->load('orgCharts');

        return response()->json([
            'success' => true,
            'state'   => $branch->state,
            'color'   => self::STATE_COLOURS[$branch->state] ?? '#6b7280',
            'chapter' => $this->formatChapter($branch),
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:20|unique:branches,code,' . $branch->id,
            'institution' => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:100',
            'status'      => 'required|in:active,inactive,suspended',
            'ranking'     => 'nullable|integer|min:1',
        ]);

        $branch->update($validated);

        return back()->with('success', 'Branch updated.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', "Branch \"{$branch->name}\" deleted.");
    }
}
