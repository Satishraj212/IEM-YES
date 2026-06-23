<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Branch;
use App\Models\BranchOrgChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    /** Every Malaysian state / federal territory is a YES state-branch account. */
    const STATES = [
        'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang',
        'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor',
        'Terengganu', 'Kuala Lumpur', 'Putrajaya', 'Labuan',
    ];

    const COLOURS = [
        'Johor' => '#1a6b3c', 'Kedah' => '#c0392b', 'Kelantan' => '#0a5a6b',
        'Melaka' => '#b91c1c', 'Negeri Sembilan' => '#7c3aed', 'Pahang' => '#0e7490',
        'Penang' => '#d97706', 'Perak' => '#475569', 'Perlis' => '#15803d',
        'Sabah' => '#0369a1', 'Sarawak' => '#9333ea', 'Selangor' => '#5b21b6',
        'Terengganu' => '#0891b2', 'Kuala Lumpur' => '#003366',
        'Putrajaya' => '#c8a84b', 'Labuan' => '#2563eb',
    ];

    public function index()
    {
        // Ensure every state has a branch account
        foreach (self::STATES as $state) {
            Branch::firstOrCreate(
                ['name' => $state, 'code' => null],
                ['state' => $state, 'status' => 'active']
            );
        }

        $branches = Branch::whereIn('name', self::STATES)
            ->whereNull('code')
            ->withCount('members')
            ->with(['orgCharts' => fn ($q) => $q->orderByDesc('academic_year')])
            ->get()
            ->keyBy('name');

        // Keep the canonical order
        $states = collect(self::STATES)->map(function ($name) use ($branches) {
            $b = $branches->get($name);
            return [
                'id'         => $b->id,
                'name'       => $name,
                'color'      => self::COLOURS[$name] ?? '#6b7280',
                'members'    => $b->member_count ?: $b->members_count,
                'org_charts' => $b->orgCharts->map(fn ($oc) => $this->formatChart($oc))->values(),
            ];
        })->values();

        $totalMembers = $states->sum('members');
        $totalUploaded = BranchOrgChart::whereIn('branch_id', $branches->pluck('id'))->count();

        return view('admin.chapters', [
            'states'        => $states,
            'totalBranches' => count(self::STATES),
            'totalMembers'  => $totalMembers,
            'totalUploaded' => $totalUploaded,
            'pageTitle'     => 'State Branches',
            'pageSubtitle'  => 'Org Charts',
            'pageDesc'      => 'State branch organisation charts',
        ]);
    }

    private function formatChart(BranchOrgChart $oc): array
    {
        $isPdf = str_ends_with(strtolower($oc->file_path), '.pdf');
        return [
            'id'            => $oc->id,
            'academic_year' => $oc->academic_year,
            'url'           => $oc->url,
            'is_pdf'        => $isPdf,
        ];
    }

    /** HQ self-uploads a state branch's org chart for an academic year (no review). */
    public function uploadOrgChart(Request $request, Branch $branch)
    {
        $data = $request->validate([
            'academic_year' => 'required|string|max:20',
            'chart'         => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:8192',
        ]);

        // Replace any existing chart for the same year.
        $existing = BranchOrgChart::where('branch_id', $branch->id)
            ->where('academic_year', $data['academic_year'])->first();
        if ($existing && $existing->file_path) {
            Storage::disk('public')->delete($existing->file_path);
        }

        $path = $request->file('chart')->store('state-org-charts', 'public');

        $oc = BranchOrgChart::updateOrCreate(
            ['branch_id' => $branch->id, 'academic_year' => $data['academic_year']],
            [
                'file_path'   => $path,
                'status'      => 'approved',   // HQ-managed — no review pipeline
                'is_current'  => true,
                'uploaded_by' => Auth::id(),
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
            ]
        );

        // Only the latest is the current one.
        BranchOrgChart::where('branch_id', $branch->id)
            ->where('id', '!=', $oc->id)
            ->update(['is_current' => false]);

        ActivityLog::record($branch->id, 'orgchart_submitted',
            "Org chart uploaded for {$branch->name} ({$data['academic_year']})", Auth::id(), $oc);

        return response()->json(['success' => true, 'chart' => $this->formatChart($oc->fresh())]);
    }

    /** Remove a state branch's org chart for a year. */
    public function removeOrgChart(BranchOrgChart $orgChart)
    {
        if ($orgChart->file_path) {
            Storage::disk('public')->delete($orgChart->file_path);
        }
        $branch = $orgChart->branch;
        $year   = $orgChart->academic_year;
        $orgChart->delete();

        ActivityLog::record($branch?->id, 'orgchart_removed',
            "Org chart removed for {$branch?->name} ({$year})", Auth::id());

        return response()->json(['success' => true]);
    }
}
