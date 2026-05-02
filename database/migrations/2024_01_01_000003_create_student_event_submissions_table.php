<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_event_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('university');
            $table->string('university_full');
            $table->string('category');
            $table->string('event_date');               // kept as string — can be "2–4 Apr 2025"
            $table->string('submitted_by');
            $table->enum('stage', ['pending', 'ppw', 'budget', 'approved', 'rejected'])
                  ->default('pending');
            $table->json('stage_history')->nullable();  // array of past stages
            $table->json('budget')->nullable();         // {"venue":2500,"catering":1800,...}
            $table->text('description')->nullable();
            $table->text('admin_notes')->nullable();
            // PPW document
            $table->string('ppw_path')->nullable();
            $table->string('ppw_filename')->nullable();
            $table->string('ppw_size')->nullable();
            // Poster / artwork
            $table->string('poster_path')->nullable();
            $table->string('poster_filename')->nullable();
            // Who reviewed
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_event_submissions');
    }
};
