<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branch_org_charts', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_current');
            $table->text('review_comment')->nullable()->after('status');
            $table->timestamp('reviewed_at')->nullable()->after('review_comment');
            $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')->constrained('users')->nullOnDelete();
        });

        Schema::table('branches', function (Blueprint $table) {
            // When HQ last asked this chapter to upload an org chart
            $table->timestamp('org_chart_requested_at')->nullable()->after('org_chart_path');
        });
    }

    public function down(): void
    {
        Schema::table('branch_org_charts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['status', 'review_comment', 'reviewed_at']);
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('org_chart_requested_at');
        });
    }
};
