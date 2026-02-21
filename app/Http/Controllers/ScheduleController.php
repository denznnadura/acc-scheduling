<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Section;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Room;
use App\Models\Semester;
use App\Services\ConflictDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    protected $conflictService;

    public function __construct(ConflictDetectionService $conflictService)
    {
        $this->conflictService = $conflictService;
    }

    public function index(Request $request)
    {
        $query = Schedule::with([
            'section.program',
            'course',
            'faculty.user',
            'room',
            'semester',
            'enrollments'
        ]);

        if (auth()->user()->isFaculty()) {
            $query->where('faculty_id', auth()->user()->faculty->id);
        } elseif ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        $schedules = $query->orderBy(DB::raw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')"))
                           ->orderBy('start_time')
                           ->paginate(20);

        $semesters = Semester::with('academicYear')->where('is_active', true)->get();
        $sections = Section::with('program')->where('is_active', true)->get();
        $faculty = Faculty::with('user')->where('is_active', true)->get(); 
        $rooms = Room::where('is_active', true)->get();

        return view('schedules.index', compact('schedules', 'semesters', 'sections', 'faculty', 'rooms'));
    }

    public function create()
    {
        $sections = Section::with('program')->where('is_active', true)->get();
        $courses = Course::where('is_active', true)->get();
        $faculty = Faculty::with('user')->where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        $semesters = Semester::where('is_active', true)->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $times = $this->generateTimeSlots();

        return view('schedules.create', compact('sections', 'courses', 'faculty', 'rooms', 'semesters', 'days', 'times'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'course_id' => 'required|exists:courses,id',
            'faculty_id' => 'required|exists:faculty,id',
            'room_id' => 'required|exists:rooms,id',
            'semester_id' => 'required|exists:semesters,id',
            'days' => 'required|array|min:1',
            'days.*' => 'string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:lecture,laboratory',
            'max_students' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $days = $validated['days'];
            unset($validated['days']); 

            $filter = $this->conflictService->filterAvailableDays($days, $validated);
            $availableDays = $filter['available'];
            $skippedDays = $filter['skipped'];

            if (empty($availableDays)) {
                DB::rollBack();
                $errorMessages = [];
                foreach ($skippedDays as $day => $conflicts) {
                    $errorMessages[] = "<strong>{$day}:</strong> " . implode(', ', $conflicts);
                }
                return back()->withErrors(['conflict' => 'All selected slots are occupied:<br>' . implode('<br>', $errorMessages)])->withInput();
            }

            foreach ($availableDays as $day) {
                Schedule::create(array_merge($validated, ['day' => $day, 'status' => 'active']));
            }

            DB::commit();
            return redirect()->route('schedules.index')->with('success', "Schedules saved successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Schedule $schedule)
    {
        $sections = Section::with('program')->where('is_active', true)->get();
        $courses = Course::where('is_active', true)->get();
        $faculty = Faculty::with('user')->where('is_active', true)->get();
        $rooms = Room::where('is_active', true)->get();
        $semesters = Semester::where('is_active', true)->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $times = $this->generateTimeSlots();

        return view('schedules.edit', compact('schedule', 'sections', 'courses', 'faculty', 'rooms', 'semesters', 'days', 'times'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'course_id' => 'required|exists:courses,id',
            'faculty_id' => 'required|exists:faculty,id',
            'room_id' => 'required|exists:rooms,id',
            'semester_id' => 'required|exists:semesters,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'type' => 'required|in:lecture,laboratory',
            'max_students' => 'required|integer|min:1',
            'status' => 'required|in:active,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $tempSchedule = clone $schedule;
            $tempSchedule->fill($validated);
            $conflicts = $this->conflictService->detectConflicts($tempSchedule, $schedule->id);

            if (!empty($conflicts)) {
                DB::rollBack();
                return back()->withErrors(['conflict' => 'Update failed due to conflicts.'])->withInput();
            }

            $schedule->update($validated);
            DB::commit();
            return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete schedule.']);
        }
    }

    public function viewStudents(Schedule $schedule)
    {
        $schedule->load(['enrollments.student.user', 'course', 'section', 'faculty.user', 'room', 'semester']);
        return view('schedules.students', compact('schedule'));
    }

    public function downloadFullPdf()
    {
        $facultyId = auth()->user()->faculty->id;
        $schedules = Schedule::with(['course', 'section', 'room'])
            ->where('faculty_id', $facultyId)
            ->orderBy(DB::raw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')"))
            ->orderBy('start_time')->get();

        $html = $this->generateFullScheduleHtml($schedules, auth()->user()->name);
        return Pdf::loadHTML($html)->setPaper('a4', 'portrait')->download('Full-Schedule-'.auth()->user()->name.'.pdf');
    }

    public function downloadFullExcel()
    {
        $facultyId = auth()->user()->faculty->id;
        $schedules = Schedule::with(['course', 'section', 'room'])
            ->where('faculty_id', $facultyId)
            ->orderBy(DB::raw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')"))
            ->orderBy('start_time')->get();

        $filename = "Full-Schedule-".auth()->user()->name.".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['AKLAN CATHOLIC COLLEGE - FULL SCHEDULE']);
        fputcsv($handle, ['Faculty:', auth()->user()->name]);
        fputcsv($handle, []);
        fputcsv($handle, ['Day', 'Time', 'Course', 'Section', 'Room']);

        foreach($schedules as $sched) {
            fputcsv($handle, [
                $sched->day,
                date('h:i A', strtotime($sched->start_time)) . ' - ' . date('h:i A', strtotime($sched->end_time)),
                $sched->course->code,
                $sched->section->name,
                $sched->room->code
            ]);
        }
        fclose($handle);
        exit;
    }

    public function downloadFullWord()
    {
        $facultyId = auth()->user()->faculty->id;
        $schedules = Schedule::with(['course', 'section', 'room'])
            ->where('faculty_id', $facultyId)
            ->orderBy(DB::raw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')"))
            ->orderBy('start_time')->get();

        $html = $this->generateFullScheduleHtml($schedules, auth()->user()->name, true);
        
        $filename = "Full-Schedule-".auth()->user()->name.".doc";
        $headers = [
            "Content-type" => "application/vnd.ms-word",
            "Content-Disposition" => "attachment;Filename=".$filename
        ];
        return response($html, 200, $headers);
    }

    private function generateFullScheduleHtml($schedules, $name, $forWord = false)
    {
        $logoImg = "";
        
        if ($forWord) {
            // Use live URL for Word to avoid Base64 text rendering issues
            $logoUrl = asset('assets/logo.png'); 
            $logoImg = "<img src='{$logoUrl}' width='80' height='80'>";
        } else {
            // Use Base64 for PDF as it is more reliable for local file rendering in DomPDF
            $path = public_path('assets/logo.png'); 
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $logoImg = "<img src='{$base64}' style='height: 80px;'>";
            }
        }

        $rows = '';
        foreach($schedules as $sched) {
            $rows .= "<tr>
                <td style='border:1px solid #000; padding:8px;'>{$sched->day}</td>
                <td style='border:1px solid #000; padding:8px;'>".date('h:i A', strtotime($sched->start_time))." - ".date('h:i A', strtotime($sched->end_time))."</td>
                <td style='border:1px solid #000; padding:8px;'>{$sched->course->code}</td>
                <td style='border:1px solid #000; padding:8px;'>{$sched->section->name}</td>
                <td style='border:1px solid #000; padding:8px;'>{$sched->room->code}</td>
            </tr>";
        }

        return "
            <div style='text-align:center; font-family:Arial;'>
                {$logoImg}
                <h2 style='margin:5px 0;'>AKLAN CATHOLIC COLLEGE</h2>
                <p style='margin:0; font-style: italic; color: #2e7d32;'>Pro Deo Et Patria</p>
                <h3 style='margin:5px 0;'>FACULTY CLASS SCHEDULE</h3>
                <p style='margin:15px 0; text-align:left;'><strong>Name:</strong> {$name}</p>
            </div>
            <table style='width:100%; border-collapse:collapse; font-family:Arial; font-size:12px;'>
                <thead><tr style='background:#f2f2f2;'>
                    <th style='border:1px solid #000; padding:8px;'>Day</th>
                    <th style='border:1px solid #000; padding:8px;'>Time</th>
                    <th style='border:1px solid #000; padding:8px;'>Course</th>
                    <th style='border:1px solid #000; padding:8px;'>Section</th>
                    <th style='border:1px solid #000; padding:8px;'>Room</th>
                </tr></thead>
                <tbody>{$rows}</tbody>
            </table>";
    }

    private function generateTimeSlots(): array
    {
        $times = [];
        for ($hour = 7; $hour <= 20; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 30) {
                $times[] = sprintf('%02d:%02d', $hour, $minute);
            }
        }
        return $times;
    }
}