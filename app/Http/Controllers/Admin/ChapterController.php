<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChapterController extends Controller
{
    public function index()
    {
        $chapters = Branch::withCount(['members as total_members', 'events as total_events'])
            ->with('activeMembers')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.chapters', [
            'chapters'     => $chapters,
            'pageTitle'    => 'Chapters',
            'pageSubtitle' => 'Overview',
            'pageDesc'     => 'All registered student chapters',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:20|unique:branches,code',
            'institution' => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:100',
            // Admin user for this chapter
            'admin_name'  => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        $branch = Branch::create([
            'name'        => $validated['name'],
            'code'        => $validated['code'] ?? null,
            'institution' => $validated['institution'] ?? null,
            'location'    => $validated['location'] ?? null,
            'state'       => $validated['state'] ?? null,
            'status'      => 'active',
        ]);

        User::create([
            'name'      => $validated['admin_name'],
            'email'     => $validated['admin_email'],
            'password'  => Hash::make($validated['admin_password']),
            'branch_id' => $branch->id,
            'role'      => 'branch_admin',
            'status'    => 'active',
        ]);

        ActivityLog::record(
            $branch->id,
            'hq_approved',
            "Chapter created: {$branch->name}",
            Auth::id(),
            $branch
        );

        return back()->with('success', "Chapter '{$branch->name}' created with admin account.");
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return back()->with('success', 'Chapter removed.');
    }
}
