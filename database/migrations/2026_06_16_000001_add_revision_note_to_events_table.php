<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Student-facing correction comment sent when an admin reinstates (sends back)
            // an event. Distinct from internal_notes, which stay admin-private.
            $table->text('revision_note')->nullable()->after('rejection_reason');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('revision_note');
        });
    }
};
