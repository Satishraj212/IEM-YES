<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flagship_events', function (Blueprint $table) {
            $table->id();
            $table->string('short_name', 50);           // "NATSUM", "CAFEO"
            $table->string('full_name');                 // full descriptive name
            $table->unsignedSmallInteger('year');
            $table->string('event_date', 100)->nullable(); // "August 2025 (TBC)"
            $table->string('location')->nullable();
            $table->string('host')->nullable();          // e.g. "Malaysia (YES IEM)"
            $table->unsignedInteger('expected_delegates')->default(0);
            $table->enum('status', ['planning', 'upcoming', 'open', 'past'])->default('planning');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flagship_events');
    }
};
