<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\ScheduleConflict;
use Illuminate\Support\Facades\DB;

class ConflictDetectionService
{
    public function detectConflicts(Schedule $schedule, ?int $excludeId = null): array
    {
        $conflicts = [];

        // Check room conflicts
        if ($this->hasRoomConflict($schedule, $excludeId)) {
            $conflicts[] = 'Room is already booked at this time';
            // Only log if schedule has been saved
            if ($schedule->exists) {
                $this->logConflict($schedule->id, 'room', 'Room conflict detected');
            }
        }

        // Check faculty conflicts
        if ($this->hasFacultyConflict($schedule, $excludeId)) {
            $conflicts[] = 'Faculty member is already assigned to another class at this time';
            if ($schedule->exists) {
                $this->logConflict($schedule->id, 'faculty', 'Faculty conflict detected');
            }
        }

        // Check student conflicts (if section has overlapping schedules)
        if ($this->hasSectionConflict($schedule, $excludeId)) {
            $conflicts[] = 'Section already has a class scheduled at this time';
            if ($schedule->exists) {
                $this->logConflict($schedule->id, 'student', 'Section conflict detected');
            }
        }

        return $conflicts;
    }

    private function hasRoomConflict(Schedule $schedule, ?int $excludeId): bool
    {
        return $this->checkTimeConflict($schedule, $excludeId, 'room_id', $schedule->room_id);
    }

    private function hasFacultyConflict(Schedule $schedule, ?int $excludeId): bool
    {
        return $this->checkTimeConflict($schedule, $excludeId, 'faculty_id', $schedule->faculty_id);
    }

    private function hasSectionConflict(Schedule $schedule, ?int $excludeId): bool
    {
        return $this->checkTimeConflict($schedule, $excludeId, 'section_id', $schedule->section_id);
    }

    private function checkTimeConflict(Schedule $schedule, ?int $excludeId, string $column, $value): bool
    {
        $query = Schedule::where('semester_id', $schedule->semester_id)
            ->where('day', $schedule->day)
            ->where($column, $value)
            ->where('status', 'active')
            ->where(function ($q) use ($schedule) {
                // Check for time overlaps
                $q->where(function ($q2) use ($schedule) {
                    // New schedule starts during existing schedule
                    $q2->where('start_time', '<=', $schedule->start_time)
                        ->where('end_time', '>', $schedule->start_time);
                })
                    ->orWhere(function ($q2) use ($schedule) {
                        // New schedule ends during existing schedule
                        $q2->where('start_time', '<', $schedule->end_time)
                            ->where('end_time', '>=', $schedule->end_time);
                    })
                    ->orWhere(function ($q2) use ($schedule) {
                        // New schedule completely contains existing schedule
                        $q2->where('start_time', '>=', $schedule->start_time)
                            ->where('end_time', '<=', $schedule->end_time);
                    });
            });

        // Exclude current schedule if editing
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Exclude the schedule being checked if it has an ID
        if ($schedule->exists) {
            $query->where('id', '!=', $schedule->id);
        }

        return $query->exists();
    }

    private function logConflict(int $scheduleId, string $type, string $description): void
    {
        ScheduleConflict::create([
            'schedule_id' => $scheduleId,
            'conflict_type' => $type,
            'description' => $description,
            'status' => 'unresolved',
        ]);
    }

    public function resolveConflict(int $conflictId): bool
    {
        $conflict = ScheduleConflict::find($conflictId);

        if (!$conflict) {
            return false;
        }

        $conflict->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return true;
    }
}
