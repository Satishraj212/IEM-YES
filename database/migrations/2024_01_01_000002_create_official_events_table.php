<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('official_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['open', 'upcoming', 'past'])->default('upcoming');
            $table->unsignedInteger('total_seats')->nullable();
            $table->unsignedInteger('registered_count')->default(0);
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('organiser')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_published')->default(false);
            $table->text('description')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('poster_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('official_events');
    }
};
