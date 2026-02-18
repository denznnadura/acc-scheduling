// database/migrations/2024_01_01_000008_create_faculty_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('employee_id')->unique();
            $table->string('position'); // 'full_time', 'part_time', 'visiting'
            $table->string('rank')->nullable(); // 'instructor', 'assistant_professor', etc.
            $table->json('specializations')->nullable();
            $table->integer('max_units')->default(24);
            $table->integer('max_preparations')->default(5);
            $table->json('preferred_days')->nullable();
            $table->json('preferred_times')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty');
    }
};
