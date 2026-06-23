<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // A reinstated request becomes an editable "draft" that is hidden from HQ
        // until the chapter revises and resubmits it.
        DB::statement('ALTER TABLE event_budgets DROP CONSTRAINT event_budgets_status_check');
        DB::statement("ALTER TABLE event_budgets ADD CONSTRAINT event_budgets_status_check CHECK (status::text = ANY (ARRAY['draft','pending','approved','rejected']::text[]))");
    }

    public function down(): void
    {
        DB::statement("UPDATE event_budgets SET status = 'rejected' WHERE status = 'draft'");
        DB::statement('ALTER TABLE event_budgets DROP CONSTRAINT event_budgets_status_check');
        DB::statement("ALTER TABLE event_budgets ADD CONSTRAINT event_budgets_status_check CHECK (status::text = ANY (ARRAY['pending','approved','rejected']::text[]))");
    }
};
