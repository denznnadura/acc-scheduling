// database/migrations/2024_01_01_000004_create_rooms_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('building');
            $table->string('floor');
            $table->integer('capacity');
            $table->string('type'); // 'lecture', 'laboratory', 'computer_lab', 'workshop'
            $table->json('facilities')->nullable(); // projector, aircon, whiteboard, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
