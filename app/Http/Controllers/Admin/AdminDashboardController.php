<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficialEvent;
use App\Models\StudentEventSubmission;
use App\Models\FlagshipEvent;
use App\Models\ActivityLog;
use App\Models\Branch;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── Stats ──────────────────────────────────────────────────────────────
        $stats = [
            'total_members'          => Branch::sum('member_count'),
            'new_members_this_month' => Branch::sum('new_members_this_month'),
            'events_this_year'       => OfficialEvent::whereYear('start_date', now()->year)->count(),
            'events_vs_last_year'    => OfficialEvent::whereYear('start_date', now()->year)->count()
                                      - OfficialEvent::whereYear('start_date', now()->year - 1)->count(),
            'open_registrations'     => OfficialEvent::where('status', 'open')->sum('registered_count'),
            'seats_left_today'       => OfficialEvent::where('status', 'open')
                                            ->whereNotNull('total_seats')
                                            ->selectRaw('SUM(total_seats - registered_count) as seats_left')
                                            ->value('seats_left') ?? 0,
        ];

        // ── Quick-nav counts ───────────────────────────────────────────────────
        $counts = [
            'official'        => OfficialEvent::count(),
            'official_open'   => OfficialEvent::where('status', 'open')->count(),
            'student_pending' => StudentEventSubmission::whereIn('stage', ['pending', 'ppw', 'budget'])->count(),
            'flagship'        => FlagshipEvent::whereIn('status', ['planning', 'upcoming', 'open'])->count(),
        ];

        // ── Recent official events ─────────────────────────────────────────────
        $recentEvents = OfficialEvent::with('branch')
            ->orderByDesc('start_date')
            ->limit(5)
            ->get();

        // ── Student submissions (pending stages first) ─────────────────────────
        $recentSubmissions = StudentEventSubmission::orderByRaw("
                CASE stage
                    WHEN 'pending'  THEN 1
                    WHEN 'ppw'      THEN 2
                    WHEN 'budget'   THEN 3
                    WHEN 'approved' THEN 4
                    WHEN 'rejected' THEN 5
                    ELSE 6
                END ASC")
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ── Flagship events ────────────────────────────────────────────────────
        $flagshipEvents = FlagshipEvent::orderByRaw("
                CASE status
                    WHEN 'open'     THEN 1
                    WHEN 'upcoming' THEN 2
                    WHEN 'planning' THEN 3
                    WHEN 'past'     THEN 4
                    ELSE 5
                END ASC")
            ->orderByDesc('year')
            ->limit(4)
            ->get();

        // ── Activity feed ──────────────────────────────────────────────────────
        $recentActivity = ActivityLog::latest()->limit(5)->get();

        // ── Top branches ───────────────────────────────────────────────────────
        $topBranches = Branch::orderByDesc('member_count')->limit(3)->get();

        // ── Page meta (consumed by $pageTitle in layout) ───────────────────────
        $pageTitle    = 'Dashboard';
        $pageSubtitle = 'Overview';
        $pageDesc     = 'YES IEM National Admin · ' . now()->format('j F Y');

        return view('admin.dashboard', compact(
            'stats',
            'counts',
            'recentEvents',
            'recentSubmissions',
            'flagshipEvents',
            'recentActivity',
            'topBranches',
            'pageTitle',
            'pageSubtitle',
            'pageDesc',
        ));
    }
}