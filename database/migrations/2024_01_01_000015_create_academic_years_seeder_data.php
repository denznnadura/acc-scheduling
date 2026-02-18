// database/migrations/2024_01_01_000015_create_academic_years_seeder_data.php
<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\AcademicYear;

return new class extends Migration
{
    public function up(): void
    {
        AcademicYear::create([
            'code' => '2024-2025',
            'start_date' => '2024-08-01',
            'end_date' => '2025-05-31',
            'is_active' => true,
        ]);
    }

    public function down(): void
    {
        AcademicYear::where('code', '2024-2025')->delete();
    }
};
