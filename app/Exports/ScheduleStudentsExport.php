<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleStudentsExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $scheduleId;

    public function __construct($scheduleId)
    {
        $this->scheduleId = $scheduleId;
    }

    public function collection()
    {
        $schedule = Schedule::with([
            'enrollments.student.user',
            'course',
            'section',
            'faculty.user',
            'room',
            'semester.academicYear'
        ])->findOrFail($this->scheduleId);

        $data = [];

        // Schedule Info
        $data[] = [
            'label' => 'SCHEDULE INFORMATION',
            'value' => '',
            'extra1' => '',
            'extra2' => '',
            'extra3' => ''
        ];
        $data[] = ['label' => 'Course', 'value' => $schedule->course->code . ' - ' . $schedule->course->name, 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => 'Section', 'value' => $schedule->section->name, 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => 'Faculty', 'value' => $schedule->faculty->user->name, 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => 'Day', 'value' => $schedule->day, 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => 'Time', 'value' => date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)), 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => 'Room', 'value' => $schedule->room->code, 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => 'Total Enrolled', 'value' => $schedule->enrollments->count() . ' / ' . $schedule->max_students, 'extra1' => '', 'extra2' => '', 'extra3' => ''];
        $data[] = ['label' => '', 'value' => '', 'extra1' => '', 'extra2' => '', 'extra3' => ''];

        // Student Headers
        $data[] = ['label' => 'Student ID', 'value' => 'Name', 'extra1' => 'Email', 'extra2' => 'Year Level', 'extra3' => 'Enrolled Date'];

        // Students
        foreach ($schedule->enrollments as $enrollment) {
            $data[] = [
                'label' => $enrollment->student->student_id,
                'value' => $enrollment->student->user->name,
                'extra1' => $enrollment->student->user->email,
                'extra2' => 'Year ' . $enrollment->student->year_level,
                'extra3' => $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A'
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
        return 'Enrolled Students';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            10 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
