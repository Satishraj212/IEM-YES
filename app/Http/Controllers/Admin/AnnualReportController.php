<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnnualReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Render a submitted report's analytics snapshot (print-friendly).
     */
    public function view(AnnualReport $annualReport)
    {
        $data = $annualReport->report_data ?: ['meta' => []];
        $data['meta'] = array_merge($data['meta'] ?? [], [
            'branch'        => $data['meta']['branch'] ?? $annualReport->branch?->name,
            'report_year'   => $annualReport->year,
            'report_status' => $annualReport->status,
        ]);

        return view('student-section.report-document', [
            'd'    => $data,
            'back' => route('admin.annual-reports'),
        ]);
    }

    public function download(AnnualReport $annualReport)
    {
        abort_unless(Storage::disk('public')->exists($annualReport->file_path), 404, 'File not found.');

        $mime = match (pathinfo($annualReport->file_path, PATHINFO_EXTENSION)) {
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };

        return Storage::disk('public')->download(
            $annualReport->file_path,
            $annualReport->file_name ?? basename($annualReport->file_path),
            ['Content-Type' => $mime]
        );
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
            'report_approved',
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
            'report_rejected',
            "Annual report rejected for {$annualReport->branch->name}",
            Auth::id(),
            $annualReport
        );

        return back()->with('error', 'Annual report rejected.');
    }
}
