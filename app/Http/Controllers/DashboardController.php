<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Section;
use App\Models\Faculty;
use App\Models\ScheduleConflict;
use App\Models\Semester;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $data = [
            'currentSemester' => Semester::with('academicYear')->where('is_active', true)->first(),
            'courses' => Course::with('sections')->get(),
        ];

        if ($user->isAdmin()) {
            $data['totalSchedules'] = Schedule::count();
            $data['activeSections'] = Section::where('is_active', true)->count();
            $data['totalFaculty'] = Faculty::where('is_active', true)->count();
            $data['unresolvedConflicts'] = ScheduleConflict::where('status', 'unresolved')->count();
        }

        return view('dashboard', $data);
    }
}