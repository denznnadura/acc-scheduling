// database/migrations/2024_01_01_000011_create_schedules_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->string('day'); // 'Monday', 'Tuesday', etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->string('type'); // 'lecture', 'laboratory'
            $table->integer('max_students')->default(40);
            $table->integer('enrolled_students')->default(0);
            $table->string('status')->default('active'); // 'active', 'cancelled', 'completed'
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
