<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_event_id')->constrained('school_events')->onDelete('cascade');
            $table->enum('target_type', ['student', 'teacher', 'parent', 'all', 'class', 'staff']);
            $table->foreignId('target_id')->nullable(); // e.g., class_id if 'class'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_targets');
    }
};