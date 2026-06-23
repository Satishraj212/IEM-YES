<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annual_reports', function (Blueprint $table) {
            // Auto-generated reports carry an analytics snapshot, not an uploaded file.
            $table->json('report_data')->nullable()->after('title');
            $table->timestamp('submitted_at')->nullable()->after('report_data');
        });

        // file_path is no longer required (kept for any legacy uploaded reports).
        DB::statement('ALTER TABLE annual_reports ALTER COLUMN file_path DROP NOT NULL');
    }

    public function down(): void
    {
        Schema::table('annual_reports', function (Blueprint $table) {
            $table->dropColumn(['report_data', 'submitted_at']);
        });

        DB::statement("UPDATE annual_reports SET file_path = '' WHERE file_path IS NULL");
        DB::statement('ALTER TABLE annual_reports ALTER COLUMN file_path SET NOT NULL');
    }
};
