<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            // Structured content blocks (overview, programme[], audience, key_dates[], venue).
            // The rendered `content` HTML is generated from these for the public page.
            $table->json('content_blocks')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            $table->dropColumn('content_blocks');
        });
    }
};
