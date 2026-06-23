<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_budgets', function (Blueprint $table) {
            // Internal-only admin scratchpad — never shown to the chapter.
            // decision_notes remains the chapter-facing reason/feedback.
            $table->text('internal_notes')->nullable()->after('decision_notes');
        });

        Schema::table('event_budget_items', function (Blueprint $table) {
            // Per-category approved amount; total_approved is their sum.
            $table->decimal('approved_amount', 10, 2)->nullable()->after('unit_cost');
        });
    }

    public function down(): void
    {
        Schema::table('event_budgets', function (Blueprint $table) {
            $table->dropColumn('internal_notes');
        });

        Schema::table('event_budget_items', function (Blueprint $table) {
            $table->dropColumn('approved_amount');
        });
    }
};
