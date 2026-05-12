<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['members', 'events'])
            ->orderBy('name')
            ->get();

        return view('admin.branches', [
            'branches'     => $branches,
            'pageTitle'    => 'Chapters',
            'pageSubtitle' => 'All Branches',
            'pageDesc'     => 'Manage student chapter branches',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'nullable|string|max:20|unique:branches,code',
            'institution'  => 'nullable|string|max:255',
            'location'     => 'nullable|string|max:255',
            'state'        => 'nullable|string|max:100',
            'chapter'      => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive,suspended',
        ]);

        $branch = Branch::create($validated);

        ActivityLog::record(
            $branch->id,
            'hq_approved',
            "Branch created: {$branch->name}",
            Auth::id()
        );

        return back()->with('success', "Branch '{$branch->name}' created.");
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

    public function approveOrgChart(Request $request)
    {
        $branch = Branch::findOrFail($request->branch_id);

        ActivityLog::record(
            $branch->id,
            'hq_approved',
            "Org chart approved for {$branch->name}",
            Auth::id(),
            $branch
        );

        return back()->with('success', 'Organisation chart approved.');
    }

    public function rejectOrgChart(Request $request)
    {
        $branch = Branch::findOrFail($request->branch_id);

        if ($branch->org_chart_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($branch->org_chart_path);
            $branch->update(['org_chart_path' => null]);
        }

        ActivityLog::record(
            $branch->id,
            'hq_approved',
            "Org chart rejected for {$branch->name}",
            Auth::id(),
            $branch
        );

        return back()->with('success', 'Organisation chart rejected and removed.');
    }
}
