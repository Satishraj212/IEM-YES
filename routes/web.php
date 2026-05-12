<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Student\OverviewController;
use App\Http\Controllers\Student\EventsController;
use App\Http\Controllers\Student\AwardsController;
use App\Http\Controllers\Student\ReportController;
use App\Http\Controllers\Student\BudgetController;

// ── HOME ──
Route::get('/', fn () => view('welcome'))->name('home');

// ── AUTHENTICATION ──
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── PUBLIC — About ──
Route::get('/about/who-we-are', fn () => view('who-we-are'))->name('who-we-are');
Route::get('/about/milestones', fn () => view('milestone'))->name('milestone');

// ── PUBLIC — Events ──
Route::get('/events/official-board-events',  fn () => view('official-board-events'))->name('official-board-events');
Route::get('/events/student-section-events', fn () => view('student-section-events'))->name('student-section-events');
Route::get('/events/sustainability-events',  fn () => view('sustainability-events'))->name('sustainability-events');
Route::get('/events/natsum', fn () => view('Natsum'))->name('natsum');
Route::get('/events/cafeo',  fn () => view('Cafeo'))->name('cafeo');

// ── PUBLIC — Other ──
Route::get('/sustainability', fn () => view('sustainability'))->name('sustainability');
Route::get('/awards',         fn () => view('awards'))->name('awards');

// ── ADMIN DASHBOARD ──
Route::prefix('dashboard/admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/',                  [AdminDashboardController::class, 'index'])->name('dashboard');

    // Official Events
    Route::get('/official-events',        [OfficialEventController::class, 'index'])->name('official-events');
    Route::post('/official-events',       [OfficialEventController::class, 'store'])->name('official-events.store');
    Route::put('/official-events/{officialEvent}',    [OfficialEventController::class, 'update'])->name('official-events.update');
    Route::delete('/official-events/{officialEvent}', [OfficialEventController::class, 'destroy'])->name('official-events.destroy');

    // Student Events
    Route::get('/student-events',                     [StudentEventController::class, 'index'])->name('student-section-events-admin');
    Route::post('/student-events/{submission}/approve',[StudentEventController::class, 'approve'])->name('student-events.approve');
    Route::post('/student-events/{submission}/reject', [StudentEventController::class, 'reject'])->name('student-events.reject');

    // Flagship Events
    Route::get('/flagship-events',              [FlagshipEventController::class, 'index'])->name('flagship-events');
    Route::post('/flagship-events',             [FlagshipEventController::class, 'store'])->name('flagship-events.store');
    Route::put('/flagship-events/{flagshipEvent}', [FlagshipEventController::class, 'update'])->name('flagship-events.update');

    // Branches
    Route::get('/branches',                    [BranchController::class, 'index'])->name('branches');
    Route::post('/branches',                   [BranchController::class, 'store'])->name('branches.store');
    Route::put('/branches/{branch}',           [BranchController::class, 'update'])->name('branches.update');
    Route::post('/branches/org-chart/approve', [BranchController::class, 'approveOrgChart'])->name('branches.org-chart.approve');
    Route::post('/branches/org-chart/reject',  [BranchController::class, 'rejectOrgChart'])->name('branches.org-chart.reject');

    // Annual Reports
    Route::get('/annual-reports',                          [AnnualReportController::class, 'index'])->name('annual-reports');
    Route::post('/annual-reports/{annualReport}/approve',  [AnnualReportController::class, 'approve'])->name('annual-reports.approve');
    Route::post('/annual-reports/{annualReport}/reject',   [AnnualReportController::class, 'reject'])->name('annual-reports.reject');

    // Awards
    Route::get('/awards',                            [AwardController::class, 'index'])->name('awards');
    Route::post('/awards',                           [AwardController::class, 'store'])->name('awards.store');
    Route::post('/awards/assign',                    [AwardController::class, 'setWinner'])->name('awards.assign');
    Route::post('/awards/{awardCategory}/status',    [AwardController::class, 'updateStatus'])->name('awards.status');
    Route::post('/awards/{nomination}/shortlist',    [AwardController::class, 'shortlist'])->name('awards.shortlist');

    // Chapters
    Route::get('/chapters',           [ChapterController::class, 'index'])->name('chapters');
    Route::post('/chapters',          [ChapterController::class, 'store'])->name('chapters.create');
    Route::delete('/chapters/{branch}',[ChapterController::class, 'destroy'])->name('chapters.destroy');

    // Activity Log
    Route::get('/activity',          [ActivityLogController::class, 'index'])->name('activity');
    Route::post('/activity/mark-all',[ActivityLogController::class, 'markAllRead'])->name('activity.mark-all');

    // Settings (view only for now)
    Route::get('/settings', fn () => view('admin.settings'))->name('settings');
});

// ── STUDENT BRANCH DASHBOARD ──
Route::prefix('dashboard/student')->name('student.')->middleware('auth')->group(function () {

    Route::get('/',         [OverviewController::class, 'index'])->name('dashboard');
    Route::get('/overview', [OverviewController::class, 'index'])->name('overview');
    Route::post('/org-chart/upload',  [OverviewController::class, 'uploadOrgChart'])->name('org-chart.upload');
    Route::delete('/org-chart',       [OverviewController::class, 'removeOrgChart'])->name('org-chart.remove');

    Route::get('/events',                           [EventsController::class, 'index'])->name('events');
    Route::post('/events',                          [EventsController::class, 'store'])->name('events.store');
    Route::put('/events/{event}',                   [EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}',                [EventsController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/submit',           [EventsController::class, 'submit'])->name('events.submit');
    Route::post('/events/{event}/poster',           [EventsController::class, 'uploadPoster'])->name('events.poster.upload');
    Route::delete('/events/{event}/poster',         [EventsController::class, 'removePoster'])->name('events.poster.remove');
    Route::get('/events/export',                    [EventsController::class, 'export'])->name('events.export');

    Route::get('/awards',                           [AwardsController::class, 'index'])->name('awards');
    Route::post('/awards/nominate',                 [AwardsController::class, 'nominate'])->name('awards.nominate');
    Route::post('/awards/apply',                    [AwardsController::class, 'apply'])->name('awards.apply');
    Route::post('/awards/vote',                     [AwardsController::class, 'vote'])->name('awards.vote');
    Route::get('/awards/{awardCategory}/results',   [AwardsController::class, 'voteResults'])->name('awards.results');

    Route::get('/reports',                          [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/download',                 [ReportController::class, 'download'])->name('reports.download');
    Route::post('/annual-report/upload',            [ReportController::class, 'upload'])->name('annual-report.upload');

    Route::get('/budget',                           [BudgetController::class, 'index'])->name('budget');
    Route::post('/budget',                          [BudgetController::class, 'store'])->name('budget.submit');
});
