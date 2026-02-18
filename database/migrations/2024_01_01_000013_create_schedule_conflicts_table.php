// database/migrations/2024_01_01_000013_create_schedule_conflicts_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_conflicts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->string('conflict_type'); // 'room', 'faculty', 'student'
            $table->text('description');
            $table->string('status')->default('unresolved'); // 'unresolved', 'resolved', 'ignored'
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_conflicts');
    }
};
