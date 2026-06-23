<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlagshipEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FlagshipEventController extends Controller
{
    /**
     * Flagship event categories.
     * Key = short_name (used in URLs/badges), value = default full name.
     * Categories with a matching public skeleton at
     * resources/views/public/flagship/{lowercase-key}.blade.php get a custom page;
     * the rest fall back to the generic flagship-detail view.
     */
    const CATEGORIES = [
        'NATSUM' => 'National Student Summit',
        'CAFEO'  => 'Conference of ASEAN Federation of Engineering Organisations',
    ];

    /**
     * Distinguishing per-edition figures each skeleton renders.
     * The admin form shows the matching inputs for the chosen category,
     * and the values are saved into the event's `stats` JSON column.
     */
    const STAT_FIELDS = [
        'NATSUM' => [
            ['key' => 'edition',           'label' => 'Edition No.',        'placeholder' => 'e.g. 30'],
            ['key' => 'participants',      'label' => 'Participants',       'placeholder' => 'e.g. 3,500+'],
            ['key' => 'universities',      'label' => 'Universities',       'placeholder' => 'e.g. 80+'],
            ['key' => 'industry_partners', 'label' => 'Industry Partners',  'placeholder' => 'e.g. 50+'],
        ],
        'CAFEO' => [
            ['key' => 'edition',   'label' => 'Edition No.',     'placeholder' => 'e.g. 42'],
            ['key' => 'delegates', 'label' => 'Annual Delegates','placeholder' => 'e.g. 5,000+'],
            ['key' => 'nations',   'label' => 'ASEAN Nations',   'placeholder' => 'e.g. 10'],
            ['key' => 'host_code', 'label' => 'Host Country Code','placeholder' => 'e.g. MY'],
        ],
    ];

    public function index()
    {
        $events = FlagshipEvent::orderByDesc('year')->get();

        $counts = [
            'total'    => $events->count(),
            'planning' => $events->where('status', 'planning')->count(),
            'upcoming' => $events->whereIn('status', ['upcoming', 'open'])->count(),
            'past'     => $events->where('status', 'past')->count(),
        ];

        return view('admin.flagship-events', [
            'events'      => $events,
            'counts'      => $counts,
            'categories'  => self::CATEGORIES,
            'statFields'  => self::STAT_FIELDS,
            'pageTitle'   => 'Flagship',
            'pageSubtitle'=> 'Events',
            'pageDesc'    => 'NATSUM & CAFEO management',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'short_name'          => 'required|string|max:50',
            'full_name'           => 'required|string|max:255',
            'year'                => [
                'required', 'integer', 'min:2000',
                Rule::unique('flagship_events')->where(fn ($q) => $q->where('short_name', $request->short_name)),
            ],
            'event_date'          => 'nullable|string|max:100',
            'location'            => 'nullable|string|max:255',
            'host'                => 'nullable|string|max:255',
            'expected_delegates'  => 'nullable|integer|min:1',
            'status'              => 'required|in:planning,upcoming,open,past',
            'is_published'        => 'sometimes|boolean',
            'theme'               => 'nullable|string|max:255',
            'description'         => 'nullable|string',
            'content_blocks'                 => 'nullable|array',
            'content_blocks.overview'        => 'nullable|string',
            'content_blocks.audience'        => 'nullable|string',
            'content_blocks.venue'           => 'nullable|string',
            'content_blocks.programme'       => 'nullable|array',
            'content_blocks.programme.*.label' => 'nullable|string|max:255',
            'content_blocks.programme.*.text'  => 'nullable|string|max:500',
            'content_blocks.key_dates'       => 'nullable|array',
            'content_blocks.key_dates.*.label' => 'nullable|string|max:255',
            'content_blocks.key_dates.*.date'  => 'nullable|string|max:255',
            'registration_url'    => 'nullable|url|max:500',
            'stats'               => 'nullable|array',
            'stats.*'             => 'nullable|string|max:50',
        ], [
            'year.unique' => 'A :input edition already exists for this category. Edit that one instead.',
        ]);
        $data['stats'] = array_filter($data['stats'] ?? []);
        $data['content'] = $this->blocksToHtml($data['content_blocks'] ?? []);
        $event = FlagshipEvent::create($data);
        return response()->json(['event' => $event]);
    }

    public function update(Request $request, FlagshipEvent $flagshipEvent)
    {
        if ($request->boolean('_status_only')) {
            $request->validate(['status' => 'required|in:planning,upcoming,open,past']);
            $flagshipEvent->update(['status' => $request->status]);
            return response()->json(['event' => $flagshipEvent->fresh()]);
        }

        $data = $request->validate([
            'short_name'          => 'required|string|max:50',
            'full_name'           => 'required|string|max:255',
            'year'                => [
                'required', 'integer', 'min:2000',
                Rule::unique('flagship_events')
                    ->where(fn ($q) => $q->where('short_name', $request->short_name))
                    ->ignore($flagshipEvent->id),
            ],
            'event_date'          => 'nullable|string|max:100',
            'location'            => 'nullable|string|max:255',
            'host'                => 'nullable|string|max:255',
            'expected_delegates'  => 'nullable|integer|min:1',
            'status'              => 'required|in:planning,upcoming,open,past',
            'is_published'        => 'sometimes|boolean',
            'theme'               => 'nullable|string|max:255',
            'description'         => 'nullable|string',
            'content_blocks'                 => 'nullable|array',
            'content_blocks.overview'        => 'nullable|string',
            'content_blocks.audience'        => 'nullable|string',
            'content_blocks.venue'           => 'nullable|string',
            'content_blocks.programme'       => 'nullable|array',
            'content_blocks.programme.*.label' => 'nullable|string|max:255',
            'content_blocks.programme.*.text'  => 'nullable|string|max:500',
            'content_blocks.key_dates'       => 'nullable|array',
            'content_blocks.key_dates.*.label' => 'nullable|string|max:255',
            'content_blocks.key_dates.*.date'  => 'nullable|string|max:255',
            'registration_url'    => 'nullable|url|max:500',
            'stats'               => 'nullable|array',
            'stats.*'             => 'nullable|string|max:50',
        ], [
            'year.unique' => 'A :input edition already exists for this category. Edit that one instead.',
        ]);
        $data['stats'] = array_filter($data['stats'] ?? []);
        // Keep any existing content if no blocks were filled (un-migrated legacy rows).
        $data['content'] = $this->blocksToHtml($data['content_blocks'] ?? []) ?? $flagshipEvent->content;
        $flagshipEvent->update($data);
        return response()->json(['event' => $flagshipEvent->fresh()]);
    }

    public function destroy(FlagshipEvent $flagshipEvent)
    {
        $flagshipEvent->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Render the structured content blocks into the HTML the public page expects
     * (so the public views need no changes).
     */
    private function blocksToHtml(array $b): ?string
    {
        $para = fn ($s) => nl2br(e(trim($s)));
        $list = function (array $rows, string $second) {
            $out = '';
            foreach ($rows as $r) {
                $label = trim($r['label'] ?? '');
                $val   = trim($r[$second] ?? '');
                if ($label === '' && $val === '') continue;
                $sep = ($label !== '' && $val !== '') ? ' — ' : '';
                $out .= "  <li>" . ($label !== '' ? '<strong>' . e($label) . '</strong>' : '') . $sep . e($val) . "</li>\n";
            }
            return $out;
        };

        $h = '';
        if (!empty($b['overview'])) {
            $h .= "<h2>About This Edition</h2>\n<p>" . $para($b['overview']) . "</p>\n\n";
        }
        if (!empty($b['programme']) && ($rows = $list($b['programme'], 'text')) !== '') {
            $h .= "<h2>Programme Highlights</h2>\n<ul>\n{$rows}</ul>\n\n";
        }
        if (!empty($b['audience'])) {
            $h .= "<h2>Who Should Attend</h2>\n<p>" . $para($b['audience']) . "</p>\n\n";
        }
        if (!empty($b['key_dates']) && ($rows = $list($b['key_dates'], 'date')) !== '') {
            $h .= "<h2>Key Dates</h2>\n<ul>\n{$rows}</ul>\n\n";
        }
        if (!empty($b['venue'])) {
            $h .= "<h2>Venue &amp; Travel</h2>\n<p>" . $para($b['venue']) . "</p>\n";
        }

        return trim($h) ?: null;
    }
}