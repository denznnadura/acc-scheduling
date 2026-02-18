<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentScheduleExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $studentId;

    public function __construct($studentId)
    {
        $this->studentId = $studentId;
    }

    public function collection()
    {
        $student = Student::with([
            'user',
            'program',
            'section.schedules' => function ($query) {
                $query->where('status', 'active')
                    ->with(['course', 'faculty.user', 'room', 'semester']);
            }
        ])->findOrFail($this->studentId);

        $data = [];

        // Student Info Row
        $data[] = [
            'info' => 'STUDENT INFORMATION',
            'value' => '',
            'extra1' => '',
            'extra2' => '',
            'extra3' => '',
            'extra4' => '',
            'extra5' => ''
        ];
        $data[] = ['info' => 'Student ID', 'value' => $student->student_id, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => ''];
        $data[] = ['info' => 'Name', 'value' => $student->user->name, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => ''];
        $data[] = ['info' => 'Program', 'value' => $student->program->name, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => ''];
        $data[] = ['info' => 'Section', 'value' => $student->section->name, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => ''];
        $data[] = ['info' => 'Year Level', 'value' => $student->year_level, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => ''];
        $data[] = ['info' => '', 'value' => '', 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => ''];

        // Schedule Headers
        $data[] = ['info' => 'Course Code', 'value' => 'Course Name', 'extra1' => 'Faculty', 'extra2' => 'Day', 'extra3' => 'Time', 'extra4' => 'Room', 'extra5' => 'Units'];

        // Schedules
        foreach ($student->section->schedules as $schedule) {
            $data[] = [
                'info' => $schedule->course->code,
                'value' => $schedule->course->name,
                'extra1' => $schedule->faculty->user->name,
                'extra2' => $schedule->day,
                'extra3' => date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                'extra4' => $schedule->room->code,
                'extra5' => $schedule->course->units
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Student Schedule';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            8 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
