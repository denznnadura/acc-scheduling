<?php

namespace App\Exports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacultyLoadExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $semesterId;

    public function __construct($semesterId)
    {
        $this->semesterId = $semesterId;
    }

    public function collection()
    {
        $facultyLoads = Faculty::with([
            'user',
            'department',
            'schedules' => function ($query) {
                $query->where('semester_id', $this->semesterId)
                    ->where('status', 'active')
                    ->with(['course', 'section', 'room']);
            }
        ])
            ->where('is_active', true)
            ->get();

        $data = [];
        foreach ($facultyLoads as $faculty) {
            $totalUnits = $faculty->schedules->sum(fn($s) => $s->course->units);
            $totalPreps = $faculty->schedules->unique('course_id')->count();

            foreach ($faculty->schedules as $schedule) {
                $data[] = [
                    'faculty_name' => $faculty->user->name,
                    'employee_id' => $faculty->employee_id,
                    'department' => $faculty->department->name,
                    'course_code' => $schedule->course->code,
                    'course_name' => $schedule->course->name,
                    'section' => $schedule->section->name,
                    'day' => $schedule->day,
                    'time' => date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                    'room' => $schedule->room->code,
                    'units' => $schedule->course->units,
                    'total_units' => $totalUnits,
                    'total_preps' => $totalPreps,
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Faculty Name',
            'Employee ID',
            'Department',
            'Course Code',
            'Course Name',
            'Section',
            'Day',
            'Time',
            'Room',
            'Units',
            'Total Units',
            'Total Preps'
        ];
    }

    public function title(): string
    {
        return 'Faculty Load';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
