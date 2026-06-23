<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventsController extends Controller
{
    // ── Index ──────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        $query = Event::forBranch($branch->id)->with(['budget.items', 'registrations']);

        // Filter
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->query('sort', 'date');
        match ($sort) {
            'name'   => $query->orderBy('title'),
            'status' => $query->orderBy('status'),
            default  => $query->orderBy('start_date'),
        };

        $events = $query->withTrashed(false)->paginate(20)->withQueryString();

        // Stat counts. "Reinstate pending" = a draft that HQ sent back for revision
        // (it carries a revision_note); a plain draft has never been through review.
        $stats = [
            'total'     => Event::forBranch($branch->id)->count(),
            'approved'  => Event::forBranch($branch->id)->where('status', 'approved')->count(),
            'published' => Event::forBranch($branch->id)->where('track_published', true)->count(),
            'reinstate' => Event::forBranch($branch->id)->where('status', 'draft')->whereNotNull('revision_note')->count(),
            'draft'     => Event::forBranch($branch->id)->where('status', 'draft')->whereNull('revision_note')->count(),
            'review'    => Event::forBranch($branch->id)->where('status', 'submitted')->count(),
        ];

        return view('student-section.my-events', compact('user', 'branch', 'events', 'stats'));
    }

    // ── Store (create) ─────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'category'           => ['required', Rule::in(Event::CATEGORIES)],
            'start_date'         => 'required|date',
            'end_date'           => 'nullable|date|after_or_equal:start_date',
            'venue'              => 'required|string|max:255',
            'action'             => ['nullable', Rule::in(['draft', 'submit'])],
            'description'        => 'nullable|string',
            'poster'             => 'nullable|image|max:5120',
            'ppw'                => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'tags'               => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        // "Submit for HQ Review" forwards to admin; otherwise it's saved as a draft.
        $submitting = $request->input('action') === 'submit';

        DB::transaction(function () use ($validated, $request, $user, $branch, $submitting) {
            // Poster upload
            $posterPath = null;
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store(
                    "branches/{$branch->id}/event-posters", 'public'
                );
            }

            // PPW / supporting document upload
            $ppwPath = null;
            $ppwName = null;
            if ($request->hasFile('ppw')) {
                $ppwName = $request->file('ppw')->getClientOriginalName();
                $ppwPath = $request->file('ppw')->store(
                    "branches/{$branch->id}/ppw", 'public'
                );
            }

            // Tags
            $tags = [];
            if (!empty($validated['tags'])) {
                $tags = array_map('trim', explode(',', $validated['tags']));
                $tags = array_filter($tags);
            }

            $event = Event::create([
                'branch_id'          => $branch->id,
                'created_by'         => $user->id,
                'title'              => $validated['title'],
                'category'           => $validated['category'],
                'start_date'         => $validated['start_date'],
                'end_date'           => $validated['end_date'] ?? null,
                'venue'              => $validated['venue'],
                'status'             => $submitting ? Event::STATUS_SUBMITTED : Event::STATUS_DRAFT,
                'track_submitted'    => $submitting,
                'submitted_at'       => $submitting ? now() : null,
                'description'        => $validated['description'] ?? null,
                'poster_path'        => $posterPath,
                'ppw_path'           => $ppwPath,
                'ppw_filename'       => $ppwName,
                'tags'               => array_values($tags),
                'is_sdg'             => $request->boolean('is_sdg')
                                        || str_contains(strtolower($validated['category'] ?? ''), 'sdg')
                                        || str_contains(strtolower($validated['category'] ?? ''), 'volunteer'),
            ]);

            // Drafts stay local to the chapter; only a submission updates the admin system.
            if ($submitting) {
                ActivityLog::record(
                    $branch->id, 'event_submitted',
                    "Event submitted for review: {$event->title}",
                    $user->id, $event
                );
            }
        });

        return redirect()->route('student.events')->with(
            'success',
            $submitting ? 'Event submitted for HQ review.' : 'Event saved as draft.'
        );
    }

    // ── Update ────────────────────────────────────────────────────────────────

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        if (!$event->canBeEdited()) {
            return redirect()->route('student.events')
                ->with('error', 'This event is locked (under review or already decided) and can no longer be edited.');
        }

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => ['required', Rule::in(Event::CATEGORIES)],
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'venue'        => 'required|string|max:255',
            'action'       => ['nullable', Rule::in(['draft', 'submit'])],
            'description'  => 'nullable|string',
            'tags'         => 'nullable|string',
            'poster'       => 'nullable|image|max:5120',
            'ppw'          => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // "Save & Submit" forwards to admin review; otherwise the event stays a draft.
        $submitting = $request->input('action') === 'submit';

        DB::transaction(function () use ($validated, $request, $event, $submitting) {
            $attrs = [
                'title'       => $validated['title'],
                'category'    => $validated['category'],
                'start_date'  => $validated['start_date'],
                'end_date'    => $validated['end_date'] ?? null,
                'venue'       => $validated['venue'],
                'description' => $validated['description'] ?? null,
                'tags'        => array_values(array_filter(array_map('trim', explode(',', $validated['tags'] ?? '')))),
                'is_sdg'      => $request->boolean('is_sdg')
                                 || str_contains(strtolower($validated['category']), 'sdg')
                                 || str_contains(strtolower($validated['category']), 'volunteer'),
            ];

            if ($request->hasFile('poster')) {
                if ($event->poster_path) {
                    Storage::disk('public')->delete($event->poster_path);
                }
                $attrs['poster_path'] = $request->file('poster')->store(
                    "branches/{$event->branch_id}/event-posters", 'public'
                );
            }

            if ($request->hasFile('ppw')) {
                if ($event->ppw_path) {
                    Storage::disk('public')->delete($event->ppw_path);
                }
                $attrs['ppw_filename'] = $request->file('ppw')->getClientOriginalName();
                $attrs['ppw_path']     = $request->file('ppw')->store(
                    "branches/{$event->branch_id}/ppw", 'public'
                );
            }

            $event->update($attrs);

            if ($submitting) {
                // Routes through the shared workflow so the pipeline/flags stay consistent.
                $event->submitForReview();
            }

            // Local edits aren't tracked; only a (re)submission reaches the admin system.
            if ($submitting) {
                ActivityLog::record(
                    $event->branch_id, 'event_submitted',
                    "Event submitted for review: {$event->title}",
                    Auth::id(), $event
                );
            }

        });

        return back()->with(
            'success',
            $submitting ? 'Event updated and submitted for HQ review.' : 'Event updated.'
        );
    }

    // ── Submit for review ─────────────────────────────────────────────────────

    public function submit(Event $event)
    {
        $this->authorizeEvent($event);

        if (!$event->canBeSubmitted()) {
            return back()->with('error', 'Event cannot be submitted in its current state.');
        }

        $event->submitForReview();

        ActivityLog::record(
            $event->branch_id, 'event_submitted',
            "Event submitted for review: {$event->title}",
            Auth::id(), $event
        );

        return back()->with('success', 'Event submitted for HQ review.');
    }

    // ── Publish / unpublish to the public site ────────────────────────────────

    public function togglePublish(Event $event)
    {
        $this->authorizeEvent($event);

        // Only HQ-approved events can be made public; the publish decision is the chapter's.
        if ($event->status !== Event::STATUS_APPROVED) {
            return back()->with('error', 'Only HQ-approved events can be published to the public site.');
        }

        $publish = !$event->track_published;
        $event->update(['track_published' => $publish]);

        ActivityLog::record(
            $event->branch_id,
            $publish ? 'event_published' : 'event_unpublished',
            $publish
                ? "Event published to public site: {$event->title}"
                : "Event unpublished from public site: {$event->title}",
            Auth::id(), $event
        );

        return back()->with(
            'success',
            $publish ? 'Event published — it is now live on the public site.' : 'Event unpublished — it is no longer public.'
        );
    }

    // ── Upload poster (inline) ────────────────────────────────────────────────

    public function uploadPoster(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        if (!$event->canBeEdited()) {
            return back()->with('error', 'This event is locked (under review or already decided) and its poster can no longer be changed.');
        }

        $request->validate(['poster' => 'required|image|max:5120']);

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $path = $request->file('poster')->store(
            "branches/{$event->branch_id}/event-posters", 'public'
        );
        $event->update(['poster_path' => $path]);

        return back()->with('success', 'Poster uploaded.');
    }

    // ── Remove poster ─────────────────────────────────────────────────────────

    public function removePoster(Event $event)
    {
        $this->authorizeEvent($event);

        if (!$event->canBeEdited()) {
            return back()->with('error', 'This event is locked (under review or already decided) and its poster can no longer be changed.');
        }

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
            $event->update(['poster_path' => null]);
        }

        return back()->with('success', 'Poster removed.');
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);

        if (!$event->canBeDeleted()) {
            return back()->with('error', 'Events under review or already approved cannot be deleted.');
        }

        foreach ([$event->poster_path, $event->ppw_path] as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }

        $event->delete();

        return redirect()->route('student.events')->with('success', 'Event deleted.');
    }

    // ── Export ────────────────────────────────────────────────────────────────

    public function export()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        $events = Event::forBranch($branch->id)
            ->with('budget.items', 'registrations')
            ->get();

        // In production: use Laravel Excel or Barryvdh PDF.
        // For now return JSON export placeholder.
        return response()->json([
            'branch' => $branch->name,
            'events' => $events->map(fn ($e) => [
                'id'           => $e->id,
                'title'        => $e->title,
                'category'     => $e->category,
                'start_date'   => $e->start_date?->toDateString(),
                'end_date'     => $e->end_date?->toDateString(),
                'venue'        => $e->venue,
                'status'       => $e->status,
                'registrations'=> $e->registration_count,
                'budget_total' => $e->budget?->total_requested,
            ]),
        ]);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function authorizeEvent(Event $event): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        abort_unless(
            $user->isBranchAdmin() || $event->created_by === $user->id,
            403, 'You do not have permission to modify this event.'
        );
        abort_unless($event->branch_id === $user->branch_id, 403);
    }
}