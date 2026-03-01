<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ScheduleExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
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
                    'course_code' => $schedule->course->code ?? 'N/A',
                    'course_name' => $schedule->course->name ?? 'N/A',
                    'section'     => $schedule->section->name ?? 'N/A',
                    'faculty'     => $schedule->faculty->user->name ?? 'TBA',
                    'room'        => $schedule->room->code ?? 'TBA',
                    'day'         => $schedule->day,
                    'time'        => date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                    'type'        => ucfirst($schedule->type),
                    'units'       => $schedule->course->units ?? 0,
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
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}