<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "PTA Meeting"
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // For multi-day
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable(); // "Hall" or "Zoom"
            $table->enum('type', ['pta', 'holiday', 'revision', 'lecture', 'sports', 'staff_meeting', 'other'])->nullable();
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->foreignId('term_id')->nullable()->constrained('terms')->onDelete('set null');
            $table->boolean('is_all_day')->default(true);
            $table->json('recurrence')->nullable(); // e.g., {"frequency": "weekly"}
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes(); // Recoverable deletes

            // Index for fast date queries (calendar fetching)
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_events');
    }
};