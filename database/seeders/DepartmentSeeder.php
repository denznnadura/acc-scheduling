<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create([
            'code' => 'CAS',
            'name' => 'College of Arts and Sciences',
            'type' => 'higher_education',
            'is_active' => true,
        ]);

        Department::create([
            'code' => 'CTE',
            'name' => 'College of Teacher Education',
            'type' => 'higher_education',
            'is_active' => true,
        ]);

        Department::create([
            'code' => 'TVET',
            'name' => 'Technical Vocational Education and Training',
            'type' => 'tvet',
            'is_active' => true,
        ]);
    }
}
