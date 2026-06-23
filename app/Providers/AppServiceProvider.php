<?php

namespace App\Providers;

use App\Models\AwardNomination;
use App\Models\Event;
use App\Models\FlagshipEvent;
use App\Models\StudentEventBudget;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('public.layouts.app', function ($view) {
            $routeName = request()->route()?->getName() ?? '';

            $activeNav = match(true) {
                in_array($routeName, ['who-we-are', 'milestone', 'leadership'])               => 'about',
                in_array($routeName, ['official-board-events', 'student-section-events',
                                      'sustainability-events', 'natsum', 'cafeo',
                                      'flagship.detail', 'flagship.slug'])                     => 'events',
                $routeName === 'awards'                                                        => 'awards',
                in_array($routeName, ['sustainability', 'sustainability-events'])              => 'sustainability',
                default                                                                        => 'home',
            };

            // One entry per distinct short_name — latest published year wins.
            // Categories with only draft editions are hidden from the public nav.
            $flagshipNavItems = FlagshipEvent::where('is_published', true)
                ->orderByDesc('year')
                ->get()
                ->groupBy('short_name')
                ->map(fn ($items) => $items->first())
                ->values();

            $view->with([
                'activeNav'        => $activeNav,
                'flagshipNavItems' => $flagshipNavItems,
            ]);
        });

        // Live sidebar badge counts for the student dashboard, scoped to the
        // logged-in user's chapter. Replaces the previously hard-coded numbers.
        View::composer('student-section.layouts.app', function ($view) {
            $user   = auth()->user();
            $branch = $user?->branch;

            $navCounts = ['events' => 0, 'budgets' => 0, 'awards' => 0];

            if ($branch) {
                $navCounts['events']  = Event::forBranch($branch->id)->count();
                $navCounts['budgets'] = StudentEventBudget::whereHas(
                    'event', fn ($q) => $q->where('branch_id', $branch->id)
                )->count();
                $navCounts['awards']  = AwardNomination::where('nominated_by', $user->id)
                    ->orWhere('nominee_id', $user->id)
                    ->count();
            }

            $view->with('navCounts', $navCounts);
        });
    }
}
