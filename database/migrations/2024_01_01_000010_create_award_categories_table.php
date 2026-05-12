<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('award_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->json('criteria')->nullable();
            $table->string('ribbon_css')->nullable();
            $table->enum('status', [
                'inactive', 'nominations_open', 'nominations_closed',
                'voting_active', 'voting_closed', 'announced',
            ])->default('inactive');
            $table->date('nominations_open_date')->nullable();
            $table->date('nominations_close_date')->nullable();
            $table->date('voting_open_date')->nullable();
            $table->date('voting_close_date')->nullable();
            $table->date('ceremony_date')->nullable();
            $table->unsignedSmallInteger('cycle_year')->nullable();
            $table->boolean('allow_self_apply')->default(false);
            $table->boolean('allow_nominations')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('award_categories');
    }
};
