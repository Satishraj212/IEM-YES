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

        // Stat counts
        $stats = [
            'total'    => Event::forBranch($branch->id)->count(),
            'open'     => Event::forBranch($branch->id)->where('status', 'open')->count(),
            'draft'    => Event::forBranch($branch->id)->whereIn('status', ['draft', 'upcoming'])->count(),
            'review'   => Event::forBranch($branch->id)->where('status', 'submitted')->count(),
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
            'status'             => ['required', Rule::in(['draft', 'upcoming'])],
            'description'        => 'nullable|string',
            'poster'             => 'nullable|image|max:5120',
            'tags'               => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        DB::transaction(function () use ($validated, $request, $user, $branch) {
            // Poster upload
            $posterPath = null;
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store(
                    "branches/{$branch->id}/event-posters", 'public'
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
                'status'             => $validated['status'],
                'description'        => $validated['description'] ?? null,
                'poster_path'        => $posterPath,
                'tags'               => array_values($tags),
                'is_sdg'             => str_contains(strtolower($validated['category'] ?? ''), 'sdg')
                                        || str_contains(strtolower($validated['category'] ?? ''), 'volunteer'),
            ]);

            ActivityLog::record(
                $branch->id, 'event_submitted',
                "New event created: {$event->title}",
                $user->id, $event
            );
        });

        return redirect()->route('student.events')->with('success', 'Event created and submitted for review.');
    }

    // ── Update ────────────────────────────────────────────────────────────────

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => ['required', Rule::in(Event::CATEGORIES)],
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'venue'        => 'required|string|max:255',
            'status'       => ['required', Rule::in(array_values((array) Event::STATUS_DRAFT . Event::STATUS_UPCOMING . Event::STATUS_OPEN . Event::STATUS_PAST . Event::STATUS_CANCELLED))],
            'description'  => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'tags'         => 'nullable|string',
            'poster'       => 'nullable|image|max:5120',
        ]);

        DB::transaction(function () use ($validated, $request, $event) {
            if ($request->hasFile('poster')) {
                if ($event->poster_path) {
                    Storage::disk('public')->delete($event->poster_path);
                }
                $validated['poster_path'] = $request->file('poster')->store(
                    "branches/{$event->branch_id}/event-posters", 'public'
                );
            }

            $tags = [];
            if (!empty($validated['tags'])) {
                $tags = array_values(array_filter(array_map('trim', explode(',', $validated['tags']))));
            }

            $event->update([
                'title'          => $validated['title'],
                'category'       => $validated['category'],
                'start_date'     => $validated['start_date'],
                'end_date'       => $validated['end_date'] ?? null,
                'venue'          => $validated['venue'],
                'status'         => $validated['status'],
                'description'    => $validated['description'] ?? null,
                'internal_notes' => $validated['internal_notes'] ?? null,
                'tags'           => $tags,
                'poster_path'    => $validated['poster_path'] ?? $event->poster_path,
            ]);

        });

        return response()->json(['success' => true, 'message' => 'Event updated.']);
    }

    // ── Submit for review ─────────────────────────────────────────────────────

    public function submit(Event $event)
    {
        $this->authorizeEvent($event);

        if (!$event->canBeSubmitted()) {
            return response()->json(['success' => false, 'message' => 'Event cannot be submitted in its current state.'], 422);
        }

        $event->submitForReview();

        ActivityLog::record(
            $event->branch_id, 'event_submitted',
            "Event submitted for review: {$event->title}",
            Auth::id(), $event
        );

        return response()->json(['success' => true, 'message' => 'Event submitted for HQ review.']);
    }

    // ── Upload poster (inline) ────────────────────────────────────────────────

    public function uploadPoster(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $request->validate(['poster' => 'required|image|max:5120']);

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $path = $request->file('poster')->store(
            "branches/{$event->branch_id}/event-posters", 'public'
        );
        $event->update(['poster_path' => $path]);

        return response()->json(['success' => true, 'url' => asset('storage/' . $path)]);
    }

    // ── Remove poster ─────────────────────────────────────────────────────────

    public function removePoster(Event $event)
    {
        $this->authorizeEvent($event);

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
            $event->update(['poster_path' => null]);
        }

        return response()->json(['success' => true]);
    }

    // ── Destroy ───────────────────────────────────────────────────────────────

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return response()->json(['success' => true, 'message' => 'Event deleted.']);
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