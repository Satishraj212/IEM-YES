<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('official_events', function (Blueprint $table) {
            $table->string('start_time', 20)->nullable()->after('end_date');
            $table->string('organiser_phone', 50)->nullable()->after('organiser');
        });
    }

    public function down(): void
    {
        Schema::table('official_events', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'organiser_phone']);
        });
    }
};
