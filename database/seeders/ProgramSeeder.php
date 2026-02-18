<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Department;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $cas = Department::where('code', 'CAS')->first();
        $cte = Department::where('code', 'CTE')->first();
        $tvet = Department::where('code', 'TVET')->first();

        Program::create([
            'department_id' => $cas->id,
            'code' => 'BSIT',
            'name' => 'Bachelor of Science in Information Technology',
            'type' => 'bachelor',
            'duration_years' => 4,
            'is_active' => true,
        ]);

        Program::create([
            'department_id' => $cte->id,
            'code' => 'BSED',
            'name' => 'Bachelor of Secondary Education',
            'type' => 'bachelor',
            'duration_years' => 4,
            'is_active' => true,
        ]);

        Program::create([
            'department_id' => $tvet->id,
            'code' => 'COMPUTER',
            'name' => 'Computer Systems Servicing NC II',
            'type' => 'certificate',
            'duration_months' => 6,
            'is_active' => true,
        ]);
    }
}
