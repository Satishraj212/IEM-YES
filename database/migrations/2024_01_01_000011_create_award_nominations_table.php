<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('award_nominations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('award_category_id')->constrained('award_categories')->cascadeOnDelete();
            $table->foreignId('nominated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('nominee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_email')->nullable();
            $table->string('nominee_member_id')->nullable();
            $table->string('nominee_branch')->nullable();
            $table->boolean('is_self_application')->default(false);
            $table->text('reason')->nullable();
            $table->string('nominator_name')->nullable();
            $table->string('nominator_relationship')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->text('personal_statement')->nullable();
            $table->text('achievement_1')->nullable();
            $table->text('achievement_2')->nullable();
            $table->json('document_paths')->nullable();
            $table->enum('status', [
                'pending', 'shortlisted', 'finalist', 'winner', 'rejected',
            ])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('award_nominations');
    }
};
