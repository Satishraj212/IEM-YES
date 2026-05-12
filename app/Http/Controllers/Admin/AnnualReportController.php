<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnnualReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnualReportController extends Controller
{
    public function index()
    {
        $reports = AnnualReport::with(['branch', 'submitter'])
            ->orderByDesc('year')
            ->orderBy('status')
            ->paginate(20);

        $counts = [
            'pending'  => AnnualReport::where('status', 'pending')->count(),
            'approved' => AnnualReport::where('status', 'approved')->count(),
            'rejected' => AnnualReport::where('status', 'rejected')->count(),
        ];

        return view('admin.annual-reports', [
            'reports'      => $reports,
            'counts'       => $counts,
            'pageTitle'    => 'Annual Reports',
            'pageSubtitle' => 'Review',
            'pageDesc'     => 'Branch annual report submissions',
        ]);
    }

    public function approve(Request $request, AnnualReport $annualReport)
    {
        $annualReport->update([
            'status'      => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'notes'       => $request->notes,
        ]);

        ActivityLog::record(
            $annualReport->branch_id,
            'hq_approved',
            "Annual report approved for {$annualReport->branch->name}",
            Auth::id(),
            $annualReport
        );

        return back()->with('success', 'Annual report approved.');
    }

    public function reject(Request $request, AnnualReport $annualReport)
    {
        $annualReport->update([
            'status'      => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'notes'       => $request->notes,
        ]);

        ActivityLog::record(
            $annualReport->branch_id,
            'hq_approved',
            "Annual report rejected for {$annualReport->branch->name}",
            Auth::id(),
            $annualReport
        );

        return back()->with('error', 'Annual report rejected.');
    }
}
