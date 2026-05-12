<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('category');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('venue')->nullable();
            $table->unsignedInteger('max_capacity')->nullable();
            $table->enum('status', [
                'draft', 'upcoming', 'open', 'submitted',
                'approved', 'rejected', 'past', 'cancelled',
            ])->default('draft');
            $table->string('poster_path')->nullable();
            $table->text('internal_notes')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_sdg')->default(false);
            $table->json('sdg_goals')->nullable();
            $table->boolean('track_submitted')->default(false);
            $table->boolean('track_doc_approved')->default(false);
            $table->boolean('track_budget_approved')->default(false);
            $table->boolean('track_published')->default(false);
            $table->boolean('track_rejected')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
