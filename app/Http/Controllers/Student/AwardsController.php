<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AwardCategory;
use App\Models\AwardNomination;
use App\Models\AwardVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AwardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── Index ──────────────────────────────────────────────────────────────────

    public function index()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        // All award categories for the current cycle
        $categories = AwardCategory::with(['nominations' => function ($q) {
            $q->whereIn('status', ['shortlisted', 'finalist', 'winner'])->with('votes');
        }])->get();

        // Current user's own applications / nominations
        $myNominations = AwardNomination::where('nominated_by', $user->id)
            ->orWhere('nominee_id', $user->id)
            ->with('category')
            ->latest()
            ->get();

        // Past winners (status = winner)
        $pastWinners = AwardNomination::where('status', 'winner')
            ->with(['category', 'nominee', 'nominator'])
            ->latest()
            ->take(6)
            ->get();

        // User's existing votes (keyed by category_id)
        $userVotes = AwardVote::where('voter_id', $user->id)
            ->pluck('nomination_id', 'award_category_id');

        return view('student-section.awards', compact(
            'user', 'branch', 'categories', 'myNominations', 'pastWinners', 'userVotes'
        ));
    }

    // ── Nominate ──────────────────────────────────────────────────────────────

    public function nominate(Request $request)
    {
        $validated = $request->validate([
            'award_category_id'       => 'required|exists:award_categories,id',
            'nominee_name'            => 'required|string|max:255',
            'nominee_member_id'       => 'nullable|string|max:50',
            'nominee_branch'          => 'nullable|string|max:255',
            'nominee_email'           => 'nullable|email',
            'reason'                  => 'required|string|min:50',
            'nominator_name'          => 'required|string|max:255',
            'nominator_relationship'  => 'nullable|string|max:100',
            'rating'                  => 'nullable|integer|min:1|max:5',
        ]);

        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $category = AwardCategory::findOrFail($validated['award_category_id']);

        abort_unless($category->isNominationsOpen(), 422, 'Nominations are not currently open for this award.');

        $nomination = AwardNomination::create([
            ...$validated,
            'nominated_by'       => $user->id,
            'is_self_application' => false,
        ]);

        ActivityLog::record(
            $user->branch_id, 'nomination_sent',
            "Nomination submitted for {$category->name}",
            $user->id, $nomination
        );

        return response()->json(['success' => true, 'message' => 'Nomination submitted successfully.']);
    }

    // ── Self-apply ────────────────────────────────────────────────────────────

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'award_category_id' => 'required|exists:award_categories,id',
            'applicant_name'    => 'required|string|max:255',
            'applicant_role'    => 'nullable|string|max:100',
            'personal_statement'=> 'required|string|min:50',
            'achievement_1'     => 'nullable|string|max:255',
            'achievement_2'     => 'nullable|string|max:255',
            'documents.*'       => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $category = AwardCategory::findOrFail($validated['award_category_id']);

        abort_unless($category->allow_self_apply, 403, 'Self-applications are not allowed for this award.');
        abort_unless($category->isNominationsOpen(), 422, 'Applications are not currently open.');

        // Upload documents
        $docPaths = [];
        foreach ($request->file('documents', []) as $file) {
            $docPaths[] = $file->store("awards/{$category->id}/documents/{$user->id}", 'public');
        }

        $nomination = AwardNomination::create([
            'award_category_id'   => $validated['award_category_id'],
            'nominated_by'        => $user->id,
            'nominee_id'          => $user->id,
            'nominee_name'        => $validated['applicant_name'],
            'is_self_application' => true,
            'personal_statement'  => $validated['personal_statement'],
            'achievement_1'       => $validated['achievement_1'] ?? null,
            'achievement_2'       => $validated['achievement_2'] ?? null,
            'document_paths'      => $docPaths,
            'nominator_name'      => $validated['applicant_name'],
        ]);

        ActivityLog::record(
            $user->branch_id, 'award_submitted',
            "Applied for {$category->name}",
            $user->id, $nomination
        );

        return response()->json(['success' => true, 'message' => 'Application submitted. You will be notified by email.']);
    }

    // ── Vote ──────────────────────────────────────────────────────────────────

    public function vote(Request $request)
    {
        $request->validate([
            'award_category_id' => 'required|exists:award_categories,id',
            'nomination_id'     => 'required|exists:award_nominations,id',
        ]);

        /** @var \App\Models\User $user */
        $user     = Auth::user();
        $category = AwardCategory::findOrFail($request->award_category_id);

        abort_unless($category->isVotingActive(), 422, 'Voting is not currently active for this award.');

        // Check already voted
        $existingVote = AwardVote::where('award_category_id', $category->id)
            ->where('voter_id', $user->id)
            ->first();

        if ($existingVote) {
            return response()->json(['success' => false, 'message' => 'You have already voted for this category.'], 422);
        }

        AwardVote::create([
            'award_category_id' => $category->id,
            'voter_id'          => $user->id,
            'nomination_id'     => $request->nomination_id,
            'voted_at'          => now(),
        ]);

        ActivityLog::record(
            $user->branch_id, 'award_voted',
            "Voted in {$category->name}",
            $user->id
        );

        return response()->json(['success' => true, 'message' => 'Your vote has been recorded.']);
    }

    // ── Fetch vote results for a category ─────────────────────────────────────

    public function voteResults(AwardCategory $category)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $nominations = AwardNomination::where('award_category_id', $category->id)
            ->whereIn('status', ['shortlisted', 'finalist', 'winner'])
            ->with(['votes', 'nominee.branch'])
            ->get();

        $totalVotes = $nominations->sum(fn ($n) => $n->vote_count);

        $results = $nominations->map(fn ($n) => [
            'id'       => $n->id,
            'name'     => $n->display_name,
            'branch'   => $n->display_branch,
            'initials' => strtoupper(substr($n->display_name, 0, 2)),
            'votes'    => $n->vote_count,
            'percent'  => $totalVotes > 0 ? round(($n->vote_count / $totalVotes) * 100) : 0,
        ]);

        $userVote = AwardVote::where('award_category_id', $category->id)
            ->where('voter_id', $user->id)
            ->first();

        return response()->json([
            'nominations' => $results,
            'user_vote'   => $userVote?->nomination_id,
            'total_votes' => $totalVotes,
        ]);
    }
}