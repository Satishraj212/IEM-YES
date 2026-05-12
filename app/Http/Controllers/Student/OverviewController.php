<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
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
        $totalMembers  = $branch->members()->count();
        $activeMembers = $branch->activeMembers()->count();
        $totalEvents   = $branch->events()->count();
        $sdgEvents     = $branch->events()->where('is_sdg', true)->count();

        // ── Upcoming events (max 5 for the table) ─────────────────────────────
        $upcomingEvents = Event::forBranch($branch->id)
            ->whereIn('status', ['open', 'upcoming', 'approved'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->with('registrations')
            ->take(5)
            ->get();

        // ── Recent activity feed (max 10) ─────────────────────────────────────
        $activityFeed = ActivityLog::where('branch_id', $branch->id)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('student-section.overview', compact(
            'user', 'branch',
            'totalMembers', 'activeMembers',
            'totalEvents', 'sdgEvents',
            'upcomingEvents', 'activityFeed'
        ));
    }

    /**
     * Upload / replace the branch organisation chart.
     */
    public function uploadOrgChart(Request $request)
    {
        $request->validate([
            'org_chart' => 'required|file|mimes:png,jpg,jpeg,pdf|max:10240',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($user->isBranchAdmin(), 403);

        // Delete old file
        if ($branch->org_chart_path) {
            Storage::disk('public')->delete($branch->org_chart_path);
        }

        $path = $request->file('org_chart')->store("branches/{$branch->id}/org-chart", 'public');
        $branch->update(['org_chart_path' => $path]);

        ActivityLog::record(
            $branch->id,
            'report_submitted',
            'Organisation chart updated',
            $user->id,
            $branch
        );

        return back()->with('success', 'Organisation chart uploaded successfully.');
    }

    /**
     * Remove the branch organisation chart.
     */
    public function removeOrgChart()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        abort_unless($user->isBranchAdmin(), 403);

        if ($branch->org_chart_path) {
            Storage::disk('public')->delete($branch->org_chart_path);
            $branch->update(['org_chart_path' => null]);
        }

        return back()->with('success', 'Organisation chart removed.');
    }
}