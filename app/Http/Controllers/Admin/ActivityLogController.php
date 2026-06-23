<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Branch;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $branchId = $request->query('branch');
        $subjectType = $request->query('subject_type');
        $subjectId   = $request->query('subject_id');

        $logs = ActivityLog::query()
            ->with(['branch', 'user'])
            // Group filter (Events / Reports / Network / Budget / Awards)
            ->when($category && isset(ActivityLog::CATEGORIES[$category]),
                fn ($q) => $q->whereIn('type', ActivityLog::typesForCategory($category)))
            // Audit trail for one branch / chapter (the "view tracking" button)
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            // Audit trail for a single record
            ->when($subjectType && $subjectId, fn ($q) =>
                $q->where('subject_type', $subjectType)->where('subject_id', $subjectId))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // Human-readable label for the active scope banner.
        $scopeBranch = $branchId ? Branch::find($branchId) : null;

        return view('admin.activity', [
            'logs'         => $logs,
            'category'     => $category,
            'scopeBranch'  => $scopeBranch,
            'pageTitle'    => 'Activity',
            'pageSubtitle' => 'Feed',
            'pageDesc'     => 'Audit trail of every action across the portal',
        ]);
    }

    public function markAllRead()
    {
        return back()->with('info', 'Activity logs do not support read/unread state.');
    }
}