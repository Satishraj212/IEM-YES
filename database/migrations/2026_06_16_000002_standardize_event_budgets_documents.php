<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_budgets', function (Blueprint $table) {
            // rejection_notes was overloaded for both approve & reject — make it neutral.
            $table->renameColumn('rejection_notes', 'decision_notes');
        });

        Schema::table('event_budgets', function (Blueprint $table) {
            // Required supporting documents submitted with every budget request.
            $table->string('ppw_path')->nullable()->after('justification');
            $table->string('ppw_filename')->nullable()->after('ppw_path');
            $table->string('budget_ppw_path')->nullable()->after('ppw_filename');
            $table->string('budget_ppw_filename')->nullable()->after('budget_ppw_path');
            $table->string('quotation_path')->nullable()->after('budget_ppw_filename');
            $table->string('quotation_filename')->nullable()->after('quotation_path');

            // Decision audit.
            $table->foreignId('decided_by')->nullable()->after('decision_notes')->constrained('users')->nullOnDelete();
            $table->timestamp('decided_at')->nullable()->after('decided_by');
        });
    }

    public function down(): void
    {
        Schema::table('event_budgets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('decided_by');
            $table->dropColumn([
                'decided_at',
                'ppw_path', 'ppw_filename',
                'budget_ppw_path', 'budget_ppw_filename',
                'quotation_path', 'quotation_filename',
            ]);
        });

        Schema::table('event_budgets', function (Blueprint $table) {
            $table->renameColumn('decision_notes', 'rejection_notes');
        });
    }
};
