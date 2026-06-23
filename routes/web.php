<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\OfficialEventController;
use App\Http\Controllers\Admin\StudentEventController;
use App\Http\Controllers\Admin\FlagshipEventController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\AnnualReportController;
use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BudgetController as AdminBudgetController;
use App\Http\Controllers\Student\OverviewController;
use App\Http\Controllers\Student\EventsController;
use App\Http\Controllers\Student\AwardsController;
use App\Http\Controllers\Student\ReportController;
use App\Http\Controllers\Student\BudgetController;

// ── HOME ──────────────────────────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'welcome'])->name('home');

// ── AUTHENTICATION ────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Bypass: clicking Admin Login goes straight to the dashboard as User ID 1
Route::get('/login/admin', function () {
    $user = \App\Models\User::find(1);
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('admin.dashboard');
})->name('login.admin');

// Student branch picker
Route::get('/login/student',  [AuthController::class, 'showStudentPicker'])->name('login.student');
Route::post('/login/student', [AuthController::class, 'loginAsStudent'])->name('login.student.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── PUBLIC — About ────────────────────────────────────────────────────────────
Route::get('/about/who-we-are', fn () => view('public.who-we-are'))->name('who-we-are');
Route::get('/about/milestones', fn () => view('public.milestone'))->name('milestone');

// ── PUBLIC — Events ───────────────────────────────────────────────────────────
Route::get('/events/official-board-events',  [PublicController::class, 'officialEvents'])->name('official-board-events');
Route::get('/events/student-section-events', [PublicController::class, 'studentEvents'])->name('student-section-events');
Route::get('/events/sustainability-events',  [PublicController::class, 'sustainabilityEvents'])->name('sustainability-events');
// Slug-based dynamic route — catches any flagship short_name automatically
Route::get('/events/flagship/{short_name}/{year?}', [PublicController::class, 'flagshipBySlug'])->name('flagship.slug');
// Legacy named routes kept as redirects for backward compatibility
Route::get('/events/natsum', fn () => redirect()->route('flagship.slug', 'natsum'))->name('natsum');
Route::get('/events/cafeo',  fn () => redirect()->route('flagship.slug', 'cafeo'))->name('cafeo');
Route::get('/events/flagship-id/{flagshipEvent}', [PublicController::class, 'flagshipDetail'])->name('flagship.detail');

// ── PUBLIC — Other ────────────────────────────────────────────────────────────
Route::get('/sustainability', fn () => view('public.sustainability'))->name('sustainability');
Route::get('/awards',         [PublicController::class, 'awards'])->name('awards');
Route::get('/leadership',                     [PublicController::class, 'leadership'])->name('leadership');
Route::get('/leadership/hq-office-bearers',         [PublicController::class, 'leadershipHq'])->name('leadership.hq');
Route::get('/leadership/state-branches',            [PublicController::class, 'leadershipStates'])->name('leadership.states');
Route::get('/leadership/state-branches/{branch}',   [PublicController::class, 'leadershipStateShow'])->name('leadership.states.show');
Route::get('/leadership/student-chapters',          [PublicController::class, 'leadershipChapters'])->name('leadership.chapters');
Route::get('/leadership/student-chapters/{branch}', [PublicController::class, 'leadershipChapterShow'])->name('leadership.chapters.show');

// ── ADMIN DASHBOARD ───────────────────────────────────────────────────────────
Route::prefix('dashboard/admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Official Events
    Route::get('/official-events',                        [OfficialEventController::class, 'index'])->name('official-events');
    Route::post('/official-events',                       [OfficialEventController::class, 'store'])->name('official-events.store');
    Route::match(['PUT','PATCH'], '/official-events/{officialEvent}', [OfficialEventController::class, 'update'])->name('official-events.update');
    Route::delete('/official-events/{officialEvent}',     [OfficialEventController::class, 'destroy'])->name('official-events.destroy');

    // Student Events
    Route::get('/student-events',                        [StudentEventController::class, 'index'])->name('student-section-events-admin');
    Route::post('/student-events/{event}/stage',         [StudentEventController::class, 'updateStage'])->name('student-events.stage');
    Route::post('/student-events/{event}/approve',       [StudentEventController::class, 'approve'])->name('student-events.approve');
    Route::post('/student-events/{event}/reject',        [StudentEventController::class, 'reject'])->name('student-events.reject');

    // Flagship Events
    Route::get('/flagship-events',                        [FlagshipEventController::class, 'index'])->name('flagship-events');
    Route::post('/flagship-events',                       [FlagshipEventController::class, 'store'])->name('flagship-events.store');
    Route::put('/flagship-events/{flagshipEvent}',        [FlagshipEventController::class, 'update'])->name('flagship-events.update');
    Route::delete('/flagship-events/{flagshipEvent}',     [FlagshipEventController::class, 'destroy'])->name('flagship-events.destroy');

    // Branches
    Route::get('/branches',                               [BranchController::class, 'index'])->name('branches');
    Route::post('/branches',                              [BranchController::class, 'store'])->name('branches.store');
    Route::put('/branches/{branch}',                      [BranchController::class, 'update'])->name('branches.update');
    Route::delete('/branches/{branch}',                   [BranchController::class, 'destroy'])->name('branches.destroy');
    Route::post('/branches/{branch}/request-org-chart',   [BranchController::class, 'requestOrgChart'])->name('branches.org-chart.request');
    Route::post('/branches/org-charts/{orgChart}/review', [BranchController::class, 'reviewOrgChart'])->name('branches.org-chart.review');

    // Annual Reports
    Route::get('/annual-reports',                                   [AnnualReportController::class, 'index'])->name('annual-reports');
    Route::get('/annual-reports/{annualReport}/view',               [AnnualReportController::class, 'view'])->name('annual-reports.view');
    Route::get('/annual-reports/{annualReport}/download',           [AnnualReportController::class, 'download'])->name('annual-reports.download');
    Route::post('/annual-reports/{annualReport}/approve',           [AnnualReportController::class, 'approve'])->name('annual-reports.approve');
    Route::post('/annual-reports/{annualReport}/reject',            [AnnualReportController::class, 'reject'])->name('annual-reports.reject');

    // Awards
    Route::get('/awards',                                 [AwardController::class, 'index'])->name('awards');
    Route::post('/awards',                                [AwardController::class, 'store'])->name('awards.store');
    Route::post('/awards/{nomination}/winner',            [AwardController::class, 'setWinner'])->name('awards.assign');
    Route::delete('/awards/{awardCategory}',              [AwardController::class, 'destroy'])->name('awards.destroy');
    Route::post('/awards/{awardCategory}/status',         [AwardController::class, 'updateStatus'])->name('awards.status');
    Route::post('/awards/{nomination}/shortlist',         [AwardController::class, 'shortlist'])->name('awards.shortlist');

    // Chapters
    Route::get('/chapters',                                  [ChapterController::class, 'index'])->name('chapters');
    // State-branch org charts are HQ-managed (self-upload, no review).
    Route::post('/chapters/{branch}/org-chart',      [ChapterController::class, 'uploadOrgChart'])->name('chapters.org-chart.upload');
    Route::delete('/chapters/org-charts/{orgChart}', [ChapterController::class, 'removeOrgChart'])->name('chapters.org-chart.remove');

    // Budget Requests
    Route::get('/budget-requests',                        [AdminBudgetController::class, 'index'])->name('budget-requests');
    Route::post('/budget-requests/{budget}/approve',      [AdminBudgetController::class, 'approve'])->name('budget-requests.approve');
    Route::post('/budget-requests/{budget}/reject',       [AdminBudgetController::class, 'reject'])->name('budget-requests.reject');
    Route::post('/budget-requests/{budget}/reimburse',    [AdminBudgetController::class, 'reimburse'])->name('budget-requests.reimburse');

    // Activity Log
    Route::get('/activity',           [ActivityLogController::class, 'index'])->name('activity');
    Route::post('/activity/mark-all', [ActivityLogController::class, 'markAllRead'])->name('activity.mark-all');

    // Settings
    Route::get('/settings', fn () => view('admin.settings'))->name('settings');
});

// ── STUDENT BRANCH DASHBOARD ──────────────────────────────────────────────────
Route::prefix('dashboard/student')->name('student.')->middleware(['auth', 'branch'])->group(function () {

    Route::get('/',         [OverviewController::class, 'index'])->name('dashboard');
    Route::get('/overview', [OverviewController::class, 'index'])->name('overview');
    Route::post('/org-chart/upload', [OverviewController::class, 'uploadOrgChart'])->name('org-chart.upload');
    Route::delete('/org-chart',      [OverviewController::class, 'removeOrgChart'])->name('org-chart.remove');

    Route::get('/events',                         [EventsController::class, 'index'])->name('events');
    Route::post('/events',                        [EventsController::class, 'store'])->name('events.store');
    Route::put('/events/{event}',                 [EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}',              [EventsController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/submit',         [EventsController::class, 'submit'])->name('events.submit');
    Route::post('/events/{event}/publish',        [EventsController::class, 'togglePublish'])->name('events.publish');
    Route::post('/events/{event}/poster',         [EventsController::class, 'uploadPoster'])->name('events.poster.upload');
    Route::delete('/events/{event}/poster',       [EventsController::class, 'removePoster'])->name('events.poster.remove');
    Route::get('/events/export',                         [EventsController::class, 'export'])->name('events.export');

    Route::get('/awards',                         [AwardsController::class, 'index'])->name('awards');
    Route::post('/awards/nominate',               [AwardsController::class, 'nominate'])->name('awards.nominate');
    Route::post('/awards/apply',                  [AwardsController::class, 'apply'])->name('awards.apply');
    Route::post('/awards/vote',                   [AwardsController::class, 'vote'])->name('awards.vote');
    Route::get('/awards/{awardCategory}/results', [AwardsController::class, 'voteResults'])->name('awards.results');

    Route::get('/reports',                        [ReportController::class, 'index'])->name('reports');
    Route::post('/reports/membership',            [ReportController::class, 'storeMembership'])->name('reports.membership');
    Route::get('/reports/preview',                [ReportController::class, 'preview'])->name('reports.preview');
    Route::post('/reports/submit',                [ReportController::class, 'submit'])->name('reports.submit');
    Route::get('/reports/{report}/document',      [ReportController::class, 'document'])->name('reports.document');
    Route::get('/reports/download',               [ReportController::class, 'download'])->name('reports.download');

    Route::get('/budget',                         [BudgetController::class, 'index'])->name('budget');
    Route::post('/budget',                        [BudgetController::class, 'store'])->name('budget.submit');
    Route::post('/budget/{budget}/receipts',      [BudgetController::class, 'uploadReceipts'])->name('budget.receipts');
    Route::post('/budget/{budget}/reinstate',     [BudgetController::class, 'reinstate'])->name('budget.reinstate');
    Route::post('/budget/{budget}/update',        [BudgetController::class, 'update'])->name('budget.update');
});