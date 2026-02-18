<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $cas = Department::where('code', 'CAS')->first();

        $courses = [
            ['code' => 'IT101', 'name' => 'Introduction to Computing', 'units' => 3, 'lecture_hours' => 2, 'lab_hours' => 1, 'type' => 'lecture_lab'],
            ['code' => 'IT102', 'name' => 'Computer Programming 1', 'units' => 3, 'lecture_hours' => 2, 'lab_hours' => 1, 'type' => 'lecture_lab'],
            ['code' => 'IT103', 'name' => 'Data Structures and Algorithms', 'units' => 3, 'lecture_hours' => 3, 'lab_hours' => 0, 'type' => 'lecture'],
        ];

        foreach ($courses as $course) {
            Course::create(array_merge($course, [
                'department_id' => $cas->id,
                'is_active' => true,
            ]));
        }
    }
}
