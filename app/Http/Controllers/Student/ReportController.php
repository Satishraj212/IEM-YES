<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        // ── Summary stats ──────────────────────────────────────────────────────
        $totalEvents    = Event::forBranch($branch->id)->count();
        $totalAttendees = EventRegistration::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
                                           ->where('status', 'attended')
                                           ->count();
        $sdgEvents      = Event::forBranch($branch->id)->where('is_sdg', true)->count();
        $ranking        = $branch->ranking;

        // ── Events by category ─────────────────────────────────────────────────
        $byCategory = Event::forBranch($branch->id)
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->category => $r->count]);

        // ── Attendance by category ─────────────────────────────────────────────
        $attendanceByCategory = EventRegistration::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->where('status', 'attended')
            ->join('events', 'event_registrations.event_id', '=', 'events.id')
            ->select('events.category', DB::raw('count(*) as count'))
            ->groupBy('events.category')
            ->pluck('count', 'events.category');

        // ── Monthly attendance trend (current academic year Sep–Aug) ───────────
        $monthlyAttendance = EventRegistration::whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->where('status', 'attended')
            ->select(
                DB::raw('YEAR(attended_at) as year'),
                DB::raw('MONTH(attended_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // ── SDG breakdown ──────────────────────────────────────────────────────
        $sdgBreakdown = Event::forBranch($branch->id)
            ->where('is_sdg', true)
            ->whereNotNull('sdg_goals')
            ->get()
            ->flatMap(fn ($e) => $e->sdg_goals ?? [])
            ->countBy()
            ->sortKeys();

        // ── Top contributors ───────────────────────────────────────────────────
        $topContributors = User::where('branch_id', $branch->id)
            ->where('status', 'active')
            ->orderByDesc('cpd_points')
            ->take(5)
            ->get();

        // ── Membership growth snapshots ────────────────────────────────────────
        $membershipGrowth = [
            ['label' => 'Sep 2024', 'count' => User::where('branch_id', $branch->id)->whereDate('joined_date', '<=', '2024-09-30')->count()],
            ['label' => 'Dec 2024', 'count' => User::where('branch_id', $branch->id)->whereDate('joined_date', '<=', '2024-12-31')->count()],
            ['label' => 'Mar 2025', 'count' => User::where('branch_id', $branch->id)->whereDate('joined_date', '<=', '2025-03-31')->count()],
            ['label' => now()->format('M Y') . ' (Current)', 'count' => $branch->members()->count()],
        ];

        return view('student-section.reports', compact(
            'user', 'branch',
            'totalEvents', 'totalAttendees', 'sdgEvents', 'ranking',
            'byCategory', 'attendanceByCategory',
            'monthlyAttendance', 'sdgBreakdown',
            'topContributors', 'membershipGrowth'
        ));
    }

    /**
     * Generate and download a PDF summary report.
     * Requires barryvdh/laravel-dompdf in production.
     */
    public function download()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        // Placeholder — in production use: PDF::loadView('reports.pdf', $data)->download(...)
        return response()->json([
            'message' => 'PDF generation requires barryvdh/laravel-dompdf. Install it and implement PDF::loadView().',
            'branch'  => $branch->name,
        ]);
    }
}
