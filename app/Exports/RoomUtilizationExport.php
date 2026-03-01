<?php

namespace App\Exports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RoomUtilizationExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $semesterId;

    public function __construct($semesterId)
    {
        $this->semesterId = $semesterId;
    }

    public function collection()
    {
        return Room::withCount(['schedules' => function ($q) {
            $q->where('semester_id', $this->semesterId)
                ->where('status', 'active');
        }])
            ->where('is_active', true)
            ->get()
            ->map(function ($room) {
                $maxSlots = 50;
                $utilization = $maxSlots > 0 ? round(($room->schedules_count / $maxSlots) * 100) : 0;

                return [
                    'code' => $room->code,
                    'name' => $room->name,
                    'building' => $room->building,
                    'type' => ucwords(str_replace('_', ' ', $room->type)),
                    'capacity' => $room->capacity,
                    'schedules' => $room->schedules_count,
                    'utilization' => $utilization . '%',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Room Code',
            'Room Name',
            'Building',
            'Type',
            'Capacity',
            'Schedules',
            'Utilization'
        ];
    }

    public function title(): string
    {
        return 'Room Utilization';
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