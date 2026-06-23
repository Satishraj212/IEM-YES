<?php

use App\Console\Commands\MarkPastEvents;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-mark events as past once their date passes — runs every hour
Schedule::command(MarkPastEvents::class)->hourly();
