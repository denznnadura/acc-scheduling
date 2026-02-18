<?php

namespace App\Exports;

use App\Models\Schedule;
use App\Models\Semester;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $semesterId;

    public function __construct($semesterId)
    {
        $this->semesterId = $semesterId;
    }

    public function collection()
    {
        return Schedule::with(['course', 'section', 'faculty.user', 'room'])
            ->where('semester_id', $this->semesterId)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'course_code' => $schedule->course->code,
                    'course_name' => $schedule->course->name,
                    'section' => $schedule->section->name,
                    'faculty' => $schedule->faculty->user->name,
                    'room' => $schedule->room->code,
                    'day' => $schedule->day,
                    'time' => date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                    'type' => ucfirst($schedule->type),
                    'units' => $schedule->course->units,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Course Code',
            'Course Name',
            'Section',
            'Faculty',
            'Room',
            'Day',
            'Time',
            'Type',
            'Units'
        ];
    }

    public function title(): string
    {
        return 'Class Schedule';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
