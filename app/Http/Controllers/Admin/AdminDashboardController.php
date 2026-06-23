<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficialEvent;
use App\Models\StudentEvent;
use App\Models\StudentEventBudget;
use App\Models\BranchOrgChart;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Quick-nav counts ───────────────────────────────────────────────────
        $counts = [
            'official'           => OfficialEvent::count(),
            'official_open'      => OfficialEvent::where('status', 'open')->count(),
            'student_pending'    => StudentEvent::where('status', 'submitted')->count(),
            'budget_pending'     => StudentEventBudget::where('status', 'pending')->count(),
            'org_charts_pending' => BranchOrgChart::where('status', 'pending')->count(),
        ];

        // ── Recent official events ─────────────────────────────────────────────
        $recentEvents = OfficialEvent::with('branch')
            ->orderByDesc('start_date')
            ->limit(5)
            ->get();

        // ── Student submissions (real events, in-review first) ─────────────────
        $recentSubmissions = StudentEvent::with('branch')
            ->whereIn('status', ['submitted', 'approved', 'rejected'])
            ->orderByRaw("CASE status WHEN 'submitted' THEN 1 WHEN 'approved' THEN 2 ELSE 3 END ASC")
            ->orderByDesc('submitted_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get()
            ->map(fn ($e) => (object) [
                'title'           => $e->title,
                'university'      => $e->branch?->identity_name ?? '—',
                'university_full' => $e->branch?->identity_institution,
                'category'        => strtolower(str_replace(' ', '', $e->category ?? '')),
                'stage'           => match ($e->status) {
                    'approved' => 'approved',
                    'rejected' => 'rejected',
                    default    => $e->track_doc_approved ? 'ppw' : 'pending',
                },
                'created_at'      => $e->submitted_at ?? $e->created_at,
            ]);

        // ── Recent budget requests (pending first) ─────────────────────────────
        $recentBudgets = StudentEventBudget::with(['event.branch'])
            ->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'approved' THEN 2 WHEN 'rejected' THEN 3 ELSE 4 END")
            ->latest()
            ->limit(6)
            ->get();

        // ── Pending org chart submissions ──────────────────────────────────────
        $pendingOrgCharts = BranchOrgChart::where('status', 'pending')
            ->with('branch')
            ->oldest()
            ->limit(8)
            ->get();

        // ── Page meta ─────────────────────────────────────────────────────────
        $pageTitle    = 'Dashboard';
        $pageSubtitle = 'Overview';
        $pageDesc     = 'YES IEM National Admin · ' . now()->format('j F Y');

        return view('admin.dashboard', compact(
            'counts',
            'recentEvents',
            'recentSubmissions',
            'recentBudgets',
            'pendingOrgCharts',
            'pageTitle',
            'pageSubtitle',
            'pageDesc',
        ));
    }
}
