<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('award_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_category_id')->constrained('award_categories')->cascadeOnDelete();
            $table->foreignId('voter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('nomination_id')->constrained('award_nominations')->cascadeOnDelete();
            $table->timestamp('voted_at')->nullable();
            $table->timestamps();

            $table->unique(['award_category_id', 'voter_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('award_votes');
    }
};
