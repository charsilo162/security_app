<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('terms', function (Blueprint $table) {
            // Add phase dates after 'start_date' for logical order
            $table->date('lecture_start_date')->nullable()->after('start_date');
            $table->date('lecture_end_date')->nullable()->after('lecture_start_date');
            $table->date('revision_start_date')->nullable()->after('lecture_end_date');
            $table->date('revision_end_date')->nullable()->after('revision_start_date');
            $table->date('exam_start_date')->nullable()->after('revision_end_date');
            $table->date('exam_end_date')->nullable()->after('exam_start_date');
            // Flag and days for vacation after term (helps infer reopenings)
            $table->boolean('is_vacation_after')->default(false)->after('end_date');
            $table->integer('vacation_days')->default(0)->after('is_vacation_after');
        });
    }

    public function down(): void
    {
        Schema::table('terms', function (Blueprint $table) {
            $table->dropColumn([
                'lecture_start_date', 'lecture_end_date',
                'revision_start_date', 'revision_end_date',
                'exam_start_date', 'exam_end_date',
                'is_vacation_after', 'vacation_days'
            ]);
        });
    }
};