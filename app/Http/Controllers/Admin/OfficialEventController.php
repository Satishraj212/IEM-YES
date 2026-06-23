<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficialEvent;
use App\Models\Branch;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficialEventController extends Controller
{
    const CATEGORIES = [
        'Board Meeting', 'Retreat', 'Summit', 'Forum', 'Gala / Dinner', 'Review',
    ];

    const TAGS = [
        'Annual', 'Board', 'Strategy', 'Summit', 'Leadership', 'Training',
        'Networking', 'Gala', 'Review', 'Planning', 'Workshop', 'External',
        'Internal', 'National', 'Regional', 'Sustainability', 'Finance',
        'Governance', 'Engagement', 'YES Programme',
    ];

    const CAT_CLASSES = [
        'Board Meeting' => 'b-board',
        'Retreat'       => 'b-retreat',
        'Summit'        => 'b-summit',
        'Forum'         => 'b-forum',
        'Gala / Dinner' => 'b-gala',
        'Review'        => 'b-review',
    ];

    public function index()
    {
        OfficialEvent::syncStatus();

        $events = OfficialEvent::with('branch')
            ->orderBy('start_date')
            ->get()
            ->map(fn($e) => $this->formatForJs($e));

        $counts = [
            'all'      => OfficialEvent::count(),
            'open'     => OfficialEvent::where('status', 'open')->count(),
            'upcoming' => OfficialEvent::where('status', 'upcoming')->count(),
            'past'     => OfficialEvent::where('status', 'past')->count(),
            'draft'    => OfficialEvent::where('is_published', false)->count(),
        ];

        $branches      = Branch::orderBy('name')->get();
        $categories    = self::CATEGORIES;
        $catClasses    = self::CAT_CLASSES;
        $availableTags = self::TAGS;

        return view('admin.official-events', compact('events', 'counts', 'branches', 'categories', 'catClasses', 'availableTags') + [
            'pageTitle'    => 'Official Board',
            'pageSubtitle' => 'Events',
            'pageDesc'     => 'Manage and publish board-level events',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string',
            'location'         => 'required|string|max:255',
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
            'start_time'       => 'nullable|string|max:20',
            'branch_name'      => 'nullable|string',
            'organiser'        => 'nullable|string|max:255',
            'organiser_phone'  => 'nullable|string|max:50',
            'tags'             => 'nullable|array',
            'is_published'     => 'boolean',
            'description'      => 'nullable|string',
            'admin_notes'      => 'nullable|string',
            'poster_data'      => 'nullable|string',
        ]);

        $branch = Branch::firstOrCreate(['name' => $data['branch_name'] ?? 'National']);

        $event = OfficialEvent::create([
            'name'             => $data['name'],
            'category'         => $data['category'],
            'location'         => $data['location'],
            'start_date'       => $data['start_date'],
            'end_date'         => $data['end_date'] ?? null,
            'start_time'       => $data['start_time'] ?? null,
            'status'           => 'upcoming',
            'total_seats'      => null,
            'registered_count' => 0,
            'branch_id'        => $branch->id,
            'organiser'        => $data['organiser'] ?? null,
            'organiser_phone'  => $data['organiser_phone'] ?? null,
            'tags'             => $data['tags'] ?? [],
            'is_published'     => $data['is_published'] ?? false,
            'description'      => $data['description'] ?? null,
            'admin_notes'      => $data['admin_notes'] ?? null,
        ]);

        if (!empty($data['poster_data'])) {
            $event->poster_url = $this->savePosterBase64($data['poster_data'], $event->id);
            $event->save();
        }

        ActivityLog::record($event->branch_id, 'event_created', "New event \"{$event->name}\" created", auth()->id(), $event);

        return response()->json(['event' => $this->formatForJs($event->load('branch'))]);
    }

    public function update(Request $request, OfficialEvent $officialEvent)
    {
        $data = $request->validate([
            'name'             => 'sometimes|string|max:255',
            'category'         => 'sometimes|string',
            'location'         => 'sometimes|string|max:255',
            'start_date'       => 'sometimes|date',
            'end_date'         => 'nullable|date',
            'start_time'       => 'nullable|string|max:20',
            'status'           => 'sometimes|in:open,upcoming,past',
            'branch_name'      => 'nullable|string',
            'organiser'        => 'nullable|string|max:255',
            'organiser_phone'  => 'nullable|string|max:50',
            'tags'             => 'nullable|array',
            'is_published'     => 'sometimes|boolean',
            'description'      => 'nullable|string',
            'admin_notes'      => 'nullable|string',
            'poster_data'      => 'nullable|string',
            'remove_poster'    => 'sometimes|boolean',
        ]);

        if (!empty($data['branch_name'])) {
            $branch = Branch::firstOrCreate(['name' => $data['branch_name']]);
            $data['branch_id'] = $branch->id;
        }

        if (!empty($data['remove_poster'])) {
            $this->deletePoster($officialEvent);
            $data['poster_url'] = null;
        } elseif (!empty($data['poster_data'])) {
            $this->deletePoster($officialEvent);
            $data['poster_url'] = $this->savePosterBase64($data['poster_data'], $officialEvent->id);
        }

        unset($data['branch_name'], $data['poster_data'], $data['remove_poster']);
        $officialEvent->update($data);

        return response()->json(['event' => $this->formatForJs($officialEvent->load('branch'))]);
    }

    public function destroy(OfficialEvent $officialEvent)
    {
        $this->deletePoster($officialEvent);
        ActivityLog::record($officialEvent->branch_id, 'event_deleted', "Event \"{$officialEvent->name}\" was deleted", auth()->id(), $officialEvent);
        $officialEvent->delete();
        return response()->json(['success' => true]);
    }

    /* ── helpers ── */

    private function formatForJs(OfficialEvent $e): array
    {
        return [
            'id'               => $e->id,
            'name'             => $e->name,
            'category'         => $e->category,
            'location'         => $e->location,
            'start_date'       => $e->start_date?->toDateString(),
            'end_date'         => $e->end_date?->toDateString(),
            'start_time'       => $e->start_time,
            'status'           => $e->effective_status,
            'total_seats'      => $e->total_seats,
            'registered_count' => $e->registered_count,
            'branch_name'      => $e->branch?->name ?? 'National',
            'organiser'        => $e->organiser,
            'organiser_phone'  => $e->organiser_phone,
            'tags'             => $e->tags ?? [],
            'is_published'     => (bool) $e->is_published,
            'description'      => $e->description,
            'admin_notes'      => $e->admin_notes,
            'poster_url'       => $e->poster_url ? asset('storage/' . $e->poster_url) : null,
        ];
    }

    private function savePosterBase64(string $base64, int $eventId): string
    {
        [$meta, $data] = explode(',', $base64, 2);
        preg_match('/data:image\/(\w+);base64/', $meta, $m);
        $ext  = $m[1] ?? 'jpg';
        $path = "event-posters/event-{$eventId}.{$ext}";
        Storage::disk('public')->put($path, base64_decode($data));
        return $path;
    }

    private function deletePoster(OfficialEvent $event): void
    {
        if ($event->poster_url) {
            Storage::disk('public')->delete($event->poster_url);
        }
    }
}