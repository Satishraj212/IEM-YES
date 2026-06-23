<?php

namespace App\Console\Commands;

use App\Models\OfficialEvent;
use Illuminate\Console\Command;

class MarkPastEvents extends Command
{
    protected $signature   = 'events:mark-past';
    protected $description = 'Set status to past for any event whose date has passed';

    public function handle(): void
    {
        $updated = OfficialEvent::syncStatus();

        $this->info("Marked {$updated} official event(s) as past.");
    }
}
