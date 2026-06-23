<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Manually-tracked membership growth: the chapter records a member count
        // for each period (month) to build the growth trend.
        Schema::create('branch_membership_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->date('as_of')->comment('First day of the recorded month');
            $table->unsignedInteger('member_count');
            $table->integer('new_members')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['branch_id', 'as_of']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_membership_snapshots');
    }
};
