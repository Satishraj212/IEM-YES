<?php

use Illuminate\Support\Facades\Route;

// ── HOME ──
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── AUTHENTICATION ──
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('/login', function () {
    // Handled by LoginController
})->name('login.post');

Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

// ── ABOUT US ──
Route::get('/about/who-we-are', function () {
    return view('who-we-are');
})->name('who-we-are');

Route::get('/about/milestones', function () {
    return view('milestone');
})->name('milestone');

// ── EVENTS — General ──
Route::get('/events/official-board-events', function () {
    return view('official-board-events');
})->name('official-board-events');

Route::get('/events/student-section-events', function () {
    return view('student-section-events');
})->name('student-section-events');

Route::get('/events/sustainability-events', function () {
    return view('sustainability-events');
})->name('sustainability-events');

// ── EVENTS — Flagship ──
Route::get('/events/natsum', function () { return view('Natsum'); })->name('natsum');
Route::get('/events/cafeo',  function () { return view('Cafeo');  })->name('cafeo');

// ── SUSTAINABILITY ──
Route::get('/sustainability', function () {
    return view('sustainability');
})->name('sustainability');

// ── AWARDS (Public) ──
Route::get('/awards', function () {
    return view('awards');
})->name('awards');

// ── ADMIN DASHBOARD ──
Route::prefix('dashboard/admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard', [
            'counts' => [
                'official'        => \App\Models\OfficialEvent::count(),
                'official_open'   => \App\Models\OfficialEvent::where('status', 'open')->count(),
                'student_pending' => \App\Models\StudentEventSubmission::where('stage', 'pending')->count(),
                'flagship'        => \App\Models\FlagshipEvent::count(),
            ],
            'recentEvents'      => \App\Models\OfficialEvent::latest('start_date')->take(5)->get(),
            'recentActivity'    => \App\Models\ActivityLog::latest()->take(6)->get(),
            'recentSubmissions' => \App\Models\StudentEventSubmission::latest()->take(5)->get(),
            'flagshipEvents'    => \App\Models\FlagshipEvent::all(),
            'topBranches'       => \App\Models\Branch::orderByDesc('member_count')->take(6)->get(),
        ]);
    })->name('dashboard');

    Route::get('/official-events', function () {
        $events = \App\Models\OfficialEvent::with('branch')->latest('start_date')->get();
        return view('admin.official-events', [
            'counts' => [
                'all'      => $events->count(),
                'open'     => $events->where('status', 'open')->count(),
                'upcoming' => $events->where('status', 'upcoming')->count(),
                'past'     => $events->where('status', 'past')->count(),
            ],
            'categories' => ['Conference', 'Workshop', 'Seminar', 'Forum', 'Competition', 'Networking', 'Cultural', 'Sports'],
            'branches'   => \App\Models\Branch::orderBy('name')->get(),
            'events'     => $events,
            'catClasses' => [
                'Conference'  => 'cat-conf',
                'Workshop'    => 'cat-work',
                'Seminar'     => 'cat-semi',
                'Forum'       => 'cat-foru',
                'Competition' => 'cat-comp',
                'Networking'  => 'cat-netw',
                'Cultural'    => 'cat-cult',
                'Sports'      => 'cat-sprt',
            ],
        ]);
    })->name('official-events');

    Route::get('/student-events', function () {
        $submissions = \App\Models\StudentEventSubmission::latest()->get();
        return view('admin.student-events', [
            'counts' => [
                'pending'  => $submissions->where('stage', 'pending')->count(),
                'ppw'      => $submissions->where('stage', 'ppw')->count(),
                'budget'   => $submissions->where('stage', 'budget')->count(),
                'approved' => $submissions->where('stage', 'approved')->count(),
            ],
            'universities' => $submissions->pluck('university')->filter()->unique()->sort()->values(),
            'submissions'  => $submissions,
        ]);
    })->name('student-section-events-admin');

    Route::get('/flagship-events', function () {
        $events = \App\Models\FlagshipEvent::orderByDesc('year')->get();
        return view('admin.flagship-events', [
            'event'  => null,
            'events' => $events,
            'counts' => [
                'total'    => $events->count(),
                'planning' => $events->where('status', 'planning')->count(),
                'upcoming' => $events->where('status', 'upcoming')->count(),
                'past'     => $events->where('status', 'past')->count(),
            ],
        ]);
    })->name('flagship-events');

    Route::post('/flagship-events/store', function () {
        // Handled by FlagshipEventController
    })->name('flagship-events.store');

    Route::post('/flagship-events/{id}/update', function ($id) {
        // Handled by FlagshipEventController
    })->name('flagship-events.update');

    Route::get('/branches', function () {
        return view('admin.branches');
    })->name('branches');

    Route::post('/branches/org-chart/approve', function () {
        // Handled by BranchController
    })->name('branches.org-chart.approve');

    Route::post('/branches/org-chart/reject', function () {
        // Handled by BranchController
    })->name('branches.org-chart.reject');

    Route::get('/budget-requests', function () {
        return view('admin.budget-requests');
    })->name('budget-requests');

    Route::post('/budget-requests/{id}/approve', function ($id) {
        // Handled by BudgetController
    })->name('budget-requests.approve');

    Route::post('/budget-requests/{id}/reject', function ($id) {
        // Handled by BudgetController
    })->name('budget-requests.reject');

    Route::get('/annual-reports', function () {
        return view('admin.annual-reports');
    })->name('annual-reports');

    Route::post('/annual-reports/{id}/approve', function ($id) {
        // Handled by ReportController
    })->name('annual-reports.approve');

    Route::post('/annual-reports/{id}/reject', function ($id) {
        // Handled by ReportController
    })->name('annual-reports.reject');

    Route::get('/awards', function () {
        return view('admin.awards');
    })->name('awards');

    Route::post('/awards/assign', function () {
        // Handled by AwardController
    })->name('awards.assign');

    Route::get('/chapters', function () {
        return view('admin.chapters');
    })->name('chapters');

    Route::post('/chapters/create', function () {
        // Handled by ChapterController
    })->name('chapters.create');

    Route::get('/activity', function () {
        return view('admin.activity');
    })->name('activity');

    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

// ── STUDENT BRANCH DASHBOARD ──
Route::prefix('dashboard/student')->name('student.')->group(function () {

    Route::get('/', function () {
        return view('student-section.overview', ['activeSection' => 'overview']);
    })->name('dashboard');

    Route::get('/overview', function () {
        return view('student-section.overview', ['activeSection' => 'overview']);
    })->name('overview');

    Route::get('/events', function () {
        return view('student-section.my-events', ['activeSection' => 'events']);
    })->name('events');

    Route::get('/awards', function () {
        return view('student-section.awards', ['activeSection' => 'awards']);
    })->name('awards');

    Route::get('/reports', function () {
        return view('student-section.reports', ['activeSection' => 'reports']);
    })->name('reports');

    Route::get('/budget', function () {
        return view('student-section.budget', ['activeSection' => 'budget']);
    })->name('budget');

    Route::post('/budget/submit', function () {
        // Handled by BudgetController
    })->name('budget.submit');

    Route::post('/org-chart/upload', function () {
        // Handled by OrgChartController
    })->name('org-chart.upload');

    Route::post('/annual-report/upload', function () {
        // Handled by ReportController
    })->name('annual-report.upload');
});
