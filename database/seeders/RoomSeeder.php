<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['code' => 'R101', 'name' => 'Room 101', 'building' => 'Main Building', 'floor' => '1st Floor', 'capacity' => 40, 'type' => 'lecture'],
            ['code' => 'R102', 'name' => 'Room 102', 'building' => 'Main Building', 'floor' => '1st Floor', 'capacity' => 40, 'type' => 'lecture'],
            ['code' => 'LAB1', 'name' => 'Computer Laboratory 1', 'building' => 'IT Building', 'floor' => '2nd Floor', 'capacity' => 30, 'type' => 'computer_lab'],
            ['code' => 'LAB2', 'name' => 'Science Laboratory', 'building' => 'Science Building', 'floor' => '1st Floor', 'capacity' => 35, 'type' => 'laboratory'],
        ];

        foreach ($rooms as $room) {
            Room::create(array_merge($room, [
                'facilities' => ['projector', 'whiteboard', 'aircon'],
                'is_active' => true,
            ]));
        }
    }
}
