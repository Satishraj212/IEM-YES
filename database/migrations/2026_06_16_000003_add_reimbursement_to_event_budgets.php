<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_budgets', function (Blueprint $table) {
            // Request-time documents are gone — the breakdown is sufficient, and the
            // event PPW was already vetted at event approval.
            $table->dropColumn([
                'ppw_path', 'ppw_filename',
                'budget_ppw_path', 'budget_ppw_filename',
                'quotation_path', 'quotation_filename',
            ]);

            // Post-approval reimbursement (stage 4). Admin reimburses against receipts,
            // capped at total_approved.
            $table->decimal('total_reimbursed', 10, 2)->nullable()->after('total_approved');
            $table->foreignId('reimbursed_by')->nullable()->after('decided_at')->constrained('users')->nullOnDelete();
            $table->timestamp('reimbursed_at')->nullable()->after('reimbursed_by');
        });

        Schema::create('budget_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_budget_id')->constrained('event_budgets')->cascadeOnDelete();
            $table->string('path');
            $table->string('filename');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_receipts');

        Schema::table('event_budgets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reimbursed_by');
            $table->dropColumn(['total_reimbursed', 'reimbursed_at']);

            $table->string('ppw_path')->nullable();
            $table->string('ppw_filename')->nullable();
            $table->string('budget_ppw_path')->nullable();
            $table->string('budget_ppw_filename')->nullable();
            $table->string('quotation_path')->nullable();
            $table->string('quotation_filename')->nullable();
        });
    }
};
