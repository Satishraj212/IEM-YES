<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AwardCategory;
use App\Models\AwardNomination;
use Illuminate\Http\Request;


class AwardController extends Controller
{
    public function index()
    {
        $categories = AwardCategory::withCount(['nominations', 'votes'])
            ->orderByDesc('cycle_year')
            ->get();

        $recentNominations = AwardNomination::with(['category', 'nominee', 'nominator'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.awards', [
            'categories'        => $categories,
            'recentNominations' => $recentNominations,
            'pageTitle'         => 'Awards',
            'pageSubtitle'      => 'Management',
            'pageDesc'          => 'Manage YES IEM award categories and nominations',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'slug'                   => 'required|string|max:100|unique:award_categories,slug',
            'description'            => 'nullable|string',
            'cycle_year'             => 'required|integer|min:2020|max:2100',
            'nominations_open_date'  => 'nullable|date',
            'nominations_close_date' => 'nullable|date|after_or_equal:nominations_open_date',
            'voting_open_date'       => 'nullable|date',
            'voting_close_date'      => 'nullable|date|after_or_equal:voting_open_date',
            'ceremony_date'          => 'nullable|date',
            'allow_self_apply'       => 'boolean',
            'allow_nominations'      => 'boolean',
        ]);

        AwardCategory::create($validated);

        return back()->with('success', 'Award category created.');
    }

    public function destroy(AwardCategory $awardCategory)
    {
        $awardCategory->delete();
        return back()->with('success', 'Award category deleted.');
    }

    public function shortlist(AwardNomination $nomination)
    {
        $nomination->update(['status' => 'shortlisted']);
        return back()->with('success', 'Nomination shortlisted.');
    }

    public function setWinner(AwardNomination $nomination)
    {
        $nomination->update(['status' => 'winner']);
        return back()->with('success', 'Winner set.');
    }

    public function updateStatus(Request $request, AwardCategory $awardCategory)
    {
        $request->validate(['status' => 'required|in:inactive,nominations_open,nominations_closed,voting_active,voting_closed,announced']);
        $awardCategory->update(['status' => $request->status]);
        return back()->with('success', 'Award status updated.');
    }
}
