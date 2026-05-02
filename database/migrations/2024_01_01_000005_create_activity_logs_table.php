<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 60)->index();          // 'event_created', 'member_joined', …
            $table->text('message');                       // HTML allowed: <strong>name</strong>
            $table->string('dot_color', 60)->default('var(--navy)');
            $table->string('dot_icon', 500)->nullable();   // inline SVG path data
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
