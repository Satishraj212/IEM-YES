<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            // Live (true) shows the edition on the public site & year nav;
            // Draft (false) hides it. Default true so existing editions stay live.
            $table->boolean('is_published')->default(true)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};
