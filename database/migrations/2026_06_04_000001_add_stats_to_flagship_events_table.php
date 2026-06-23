<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            // Per-edition distinguishing figures shown on the public skeleton
            // (e.g. participants, universities, industry_partners, nations, edition).
            // Stored as a flexible key→string map so each category keeps its own stats.
            $table->json('stats')->nullable()->after('registration_url');
        });
    }

    public function down(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            $table->dropColumn('stats');
        });
    }
};
