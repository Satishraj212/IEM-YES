<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::query()
            ->when($request->type, fn($q, $t) => $q->where('type', $t))
            ->latest()
            ->paginate(20);

        return view('admin.activity', [
            'logs'         => $logs,
            'pageTitle'    => 'Activity',
            'pageSubtitle' => 'Feed',
            'pageDesc'     => 'Real-time system events',
        ]);
    }

    public function markAllRead()
    {
        return back()->with('info', 'Activity logs do not support read/unread state.');
    }
}