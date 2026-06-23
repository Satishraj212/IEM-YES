<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            $table->string('theme', 255)->nullable()->after('status');
            $table->text('description')->nullable()->after('theme');
            $table->longText('content')->nullable()->after('description');
            $table->string('registration_url', 500)->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('flagship_events', function (Blueprint $table) {
            $table->dropColumn(['theme', 'description', 'content', 'registration_url']);
        });
    }
};
