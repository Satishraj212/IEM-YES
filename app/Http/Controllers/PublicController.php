<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchOrgChart;
use App\Models\OfficialEvent;
use App\Models\StudentEvent;
use App\Models\FlagshipEvent;
use App\Models\StudentAwardCategory;
use App\Models\StudentAwardNomination;

class PublicController extends Controller
{
    public function officialEvents()
    {
        OfficialEvent::syncStatus();

        $rank = fn ($s) => match($s) { 'open' => 0, 'upcoming' => 1, default => 2 };

        $events = OfficialEvent::where('is_published', true)
            ->with('branch')
            ->orderBy('start_date')
            ->get()
            ->sort(fn ($a, $b) =>
                $rank($a->effective_status) <=> $rank($b->effective_status)
                ?: $a->start_date <=> $b->start_date
            )
            ->values();

        $eventsThisYear = $events->filter(
            fn ($e) => $e->start_date && $e->start_date->year === now()->year
        )->count();

        return view('public.official-board-events', compact('events', 'eventsThisYear'));
    }

    public function studentEvents()
    {
        $events = StudentEvent::whereIn('status', ['open', 'approved', 'past'])
            ->where('track_published', true)   // only chapter-published events are public
            ->with('branch')
            ->orderByRaw("CASE status WHEN 'open' THEN 1 WHEN 'approved' THEN 2 WHEN 'past' THEN 3 ELSE 4 END")
            ->orderBy('start_date')
            ->get();

        return view('public.student-section-events', compact('events'));
    }

    public function sustainabilityEvents()
    {
        $events = StudentEvent::where('is_sdg', true)
            ->whereIn('status', ['open', 'approved', 'past'])
            ->where('track_published', true)   // only chapter-published events are public
            ->with('branch')
            ->orderBy('start_date')
            ->get();

        $officialSdg = OfficialEvent::where('is_published', true)
            ->whereJsonContains('tags', 'SDG')
            ->orWhereJsonContains('tags', 'Sustainability')
            ->orWhereJsonContains('tags', 'Green')
            ->get();

        return view('public.sustainability-events', compact('events', 'officialSdg'));
    }

    public function awards()
    {
        $categories = StudentAwardCategory::with([
            'nominations' => fn ($q) => $q->whereIn('status', ['shortlisted', 'finalist', 'winner'])
                                          ->with(['votes', 'nominee']),
        ])->get();

        $winners = StudentAwardNomination::where('status', 'winner')
            ->with(['category', 'nominee'])
            ->latest()
            ->take(6)
            ->get();

        return view('public.awards', compact('categories', 'winners'));
    }

    public function natsum()
    {
        $event = FlagshipEvent::where('short_name', 'NATSUM')
            ->orderByDesc('year')
            ->first();

        return view('public.natsum', compact('event'));
    }

    public function cafeo()
    {
        $event = FlagshipEvent::where('short_name', 'CAFEO')
            ->orderByDesc('year')
            ->first();

        return view('public.cafeo', compact('event'));
    }

    public function flagshipBySlug(string $short_name, ?int $year = null)
    {
        // Only published editions are ever shown publicly
        $base = FlagshipEvent::whereRaw('LOWER(short_name) = ?', [strtolower($short_name)])
            ->where('is_published', true);

        if ($year) {
            $flagshipEvent = (clone $base)->where('year', $year)->firstOrFail();
        } else {
            $flagshipEvent = (clone $base)
                ->orderByRaw("CASE status WHEN 'open' THEN 1 WHEN 'upcoming' THEN 2 WHEN 'planning' THEN 3 ELSE 4 END")
                ->orderByDesc('year')
                ->firstOrFail();
        }

        // Published editions of this type, newest first — drives year nav + past editions grid
        $allEditions = (clone $base)->orderByDesc('year')->get();

        // Use event-specific skeleton if one exists, else generic
        $slug = strtolower($short_name);
        $view = view()->exists("public.flagship.{$slug}")
            ? "public.flagship.{$slug}"
            : 'public.flagship-detail';

        return view($view, compact('flagshipEvent', 'allEditions'));
    }

    public function flagshipDetail(FlagshipEvent $flagshipEvent)
    {
        abort_unless($flagshipEvent->is_published, 404);

        $allEditions = FlagshipEvent::whereRaw('LOWER(short_name) = ?', [strtolower($flagshipEvent->short_name)])
            ->where('is_published', true)
            ->orderByDesc('year')
            ->get();

        return view('public.flagship-detail', compact('flagshipEvent', 'allEditions'));
    }

    public function leadership()
    {
        return redirect()->route('leadership.hq');
    }

    /** YES HQ Office Bearers = the Kuala Lumpur organisation chart (single page). */
    public function leadershipHq()
    {
        $kl     = Branch::whereNull('code')->where('name', 'Kuala Lumpur')->with('orgCharts')->first();
        $viewer = ($kl && $kl->orgCharts->isNotEmpty()) ? $this->chartViewer($kl) : null;

        return view('public.leadership', [
            'section' => 'hq',
            'title'   => 'YES HQ Office Bearers',
            'tabs'    => collect(),
            'viewer'  => $viewer,
            'writeup' => $kl?->description,
        ]);
    }

    /** State branches index — open the first state's page. */
    public function leadershipStates()
    {
        $first = $this->stateBranchesQuery()->first();

        return $first
            ? redirect()->route('leadership.states.show', $first)
            : view('public.leadership', ['section' => 'states', 'title' => 'YES State Branches', 'tabs' => collect(), 'viewer' => null, 'writeup' => null]);
    }

    /** A single state branch's organisation chart + write-up (tabs link to each state). */
    public function leadershipStateShow(Branch $branch)
    {
        abort_unless(is_null($branch->code), 404);
        $branch->load('orgCharts');

        $tabs = $this->stateBranchesQuery()->get()->map(fn ($b) => [
            'name'   => $b->name,
            'url'    => route('leadership.states.show', $b),
            'active' => $b->id === $branch->id,
        ]);

        return view('public.leadership', [
            'section' => 'states',
            'title'   => 'YES State Branches',
            'tabs'    => $tabs,
            'viewer'  => $branch->orgCharts->isNotEmpty() ? $this->chartViewer($branch) : null,
            'writeup' => $branch->description,
        ]);
    }

    /** Student chapters index — open the first chapter's page. */
    public function leadershipChapters()
    {
        $first = $this->chaptersQuery()->first();

        return $first
            ? redirect()->route('leadership.chapters.show', $first)
            : view('public.leadership', ['section' => 'chapters', 'title' => 'Student Section Chapters', 'tabs' => collect(), 'viewer' => null, 'writeup' => null]);
    }

    /** A single chapter's approved organisation chart + write-up (tabs link to each chapter). */
    public function leadershipChapterShow(Branch $branch)
    {
        abort_unless(! is_null($branch->code), 404);
        abort_unless($branch->orgCharts()->where('status', 'approved')->exists(), 404);
        $branch->load(['orgCharts' => fn ($q) => $q->where('status', 'approved')]);

        $tabs = $this->chaptersQuery()->get()->map(fn ($b) => [
            'name'   => $b->identity_name ?? $b->name,
            'url'    => route('leadership.chapters.show', $b),
            'active' => $b->id === $branch->id,
        ]);

        return view('public.leadership', [
            'section' => 'chapters',
            'title'   => 'Student Section Chapters',
            'tabs'    => $tabs,
            'viewer'  => $this->chartViewer($branch),
            'writeup' => $branch->description,
        ]);
    }

    private function stateBranchesQuery()
    {
        return Branch::whereNull('code')->where('name', '!=', 'Kuala Lumpur')
            ->whereHas('orgCharts')->orderBy('name');
    }

    private function chaptersQuery()
    {
        return Branch::whereNotNull('code')
            ->whereHas('orgCharts', fn ($q) => $q->where('status', 'approved'))
            ->orderBy('name');
    }

    /** Map a branch to a chart-viewer payload: name + its charts, newest year first. */
    private function chartViewer($b): array
    {
        return [
            'name'        => $b->identity_name ?? $b->name,
            'institution' => $b->institution,
            'charts'      => $b->orgCharts
                ->sortByDesc('academic_year')
                ->map(fn ($oc) => [
                    'year'   => $oc->academic_year,
                    'url'    => $oc->url,
                    'is_pdf' => str_ends_with(strtolower($oc->file_path ?? ''), '.pdf'),
                ])->values()->all(),
        ];
    }

    public function welcome()
    {
        $upcomingOfficialEvents = OfficialEvent::where('is_published', true)
            ->whereIn('status', ['open', 'upcoming'])
            ->orderBy('start_date')
            ->take(3)
            ->get();

        $upcomingStudentEvents = StudentEvent::whereIn('status', ['open', 'approved'])
            ->where('track_published', true)   // only chapter-published events are public
            ->with('branch')
            ->orderBy('start_date')
            ->take(3)
            ->get();

        $sustainabilityEvents = StudentEvent::where('is_sdg', true)
            ->whereIn('status', ['open', 'approved'])
            ->where('track_published', true)   // only chapter-published events are public
            ->with('branch')
            ->orderBy('start_date')
            ->take(3)
            ->get();

        $flagshipEvents = FlagshipEvent::whereIn('status', ['open', 'upcoming', 'planning'])
            ->orderByDesc('year')
            ->take(2)
            ->get();

        $studentEventCount = StudentEvent::whereIn('status', ['open', 'approved'])
            ->where('track_published', true)
            ->count();

        return view('public.welcome', compact(
            'upcomingOfficialEvents',
            'upcomingStudentEvents',
            'sustainabilityEvents',
            'flagshipEvents',
            'studentEventCount'
        ));
    }
}
