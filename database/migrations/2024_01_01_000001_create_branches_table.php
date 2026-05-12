<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();
            $table->string('name');
            $table->string('chapter')->nullable();
            $table->string('chapter_name')->nullable();
            $table->string('institution')->nullable();
            $table->string('location')->nullable();
            $table->string('state')->nullable();
            $table->string('color', 30)->nullable();
            $table->unsignedSmallInteger('year_founded')->nullable();
            $table->string('academic_year', 20)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->boolean('is_active')->default(true);
            $table->boolean('pledge_active')->default(false);
            $table->unsignedSmallInteger('ranking')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('org_chart_path')->nullable();
            $table->unsignedInteger('member_count')->default(0);
            $table->unsignedInteger('new_members_this_month')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
