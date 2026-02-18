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
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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
            'enrollments' // ADD THIS
        ]);

        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        $schedules = $query->orderBy('day')->orderBy('start_time')->paginate(20);

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
            'days' => 'required|array|min:1', // Changed from 'day' to 'days' array
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
            unset($validated['days']); // Remove days from validated array

            $createdSchedules = [];
            $allConflicts = [];

            // Check conflicts for all days BEFORE creating any schedules
            foreach ($days as $day) {
                $tempSchedule = new Schedule(array_merge($validated, ['day' => $day]));
                $tempSchedule->status = 'active';

                $conflicts = $this->conflictService->detectConflicts($tempSchedule);

                if (!empty($conflicts)) {
                    $allConflicts[$day] = $conflicts;
                }
            }

            // If any conflicts found, rollback and show all of them
            if (!empty($allConflicts)) {
                DB::rollBack();
                $errorMessages = [];
                foreach ($allConflicts as $day => $conflicts) {
                    $errorMessages[] = "<strong>{$day}:</strong> " . implode(', ', $conflicts);
                }
                return back()->withErrors(['conflict' => 'Schedule conflicts detected:<br>' . implode('<br>', $errorMessages)])->withInput();
            }

            // Only create schedules if NO conflicts on ANY day
            foreach ($days as $day) {
                $schedule = Schedule::create(array_merge(
                    $validated,
                    ['day' => $day, 'status' => 'active']
                ));
                $createdSchedules[] = $schedule;
            }

            DB::commit();

            $count = count($createdSchedules);
            $message = $count === 1
                ? 'Schedule created successfully.'
                : "{$count} schedules created successfully for multiple days.";

            return redirect()->route('schedules.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create schedule: ' . $e->getMessage()])->withInput();
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
            $schedule->update($validated);

            // Check for conflicts (excluding current schedule)
            $conflicts = $this->conflictService->detectConflicts($schedule, $schedule->id);

            if (!empty($conflicts)) {
                DB::rollBack();
                return back()->withErrors(['conflict' => 'Schedule conflicts detected: ' . implode(', ', $conflicts)])->withInput();
            }

            DB::commit();

            return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update schedule: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete schedule: ' . $e->getMessage()]);
        }
    }

    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'faculty_id' => 'nullable|exists:faculty,id',
            'room_id' => 'nullable|exists:rooms,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'semester_id' => 'required|exists:semesters,id',
            'exclude_id' => 'nullable|exists:schedules,id',
        ]);

        $conflicts = [];

        $query = Schedule::where('semester_id', $validated['semester_id'])
            ->where('day', $validated['day'])
            ->where('status', 'active')
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q2) use ($validated) {
                        $q2->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            });

        if (isset($validated['exclude_id'])) {
            $query->where('id', '!=', $validated['exclude_id']);
        }

        if (isset($validated['faculty_id'])) {
            $facultyConflict = (clone $query)->where('faculty_id', $validated['faculty_id'])->exists();
            if ($facultyConflict) {
                $conflicts[] = 'Faculty is not available at this time';
            }
        }

        if (isset($validated['room_id'])) {
            $roomConflict = (clone $query)->where('room_id', $validated['room_id'])->exists();
            if ($roomConflict) {
                $conflicts[] = 'Room is not available at this time';
            }
        }

        return response()->json([
            'available' => empty($conflicts),
            'conflicts' => $conflicts,
        ]);
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
    public function viewStudents(Schedule $schedule)
    {
        $schedule->load([
            'enrollments.student.user', // Load enrollments instead of section.students
            'course',
            'faculty.user',
            'room',
            'semester.academicYear'
        ]);

        return view('schedules.students', compact('schedule'));
    }


    // Students List PDF Export
    public function studentsListPdf(Schedule $schedule)
    {
        $schedule->load([
            'enrollments.student.user',
            'course',
            'faculty.user',
            'room',
            'semester.academicYear',
            'section'
        ]);

        $pdf = Pdf::loadView('schedules.students-pdf', compact('schedule'));
        return $pdf->download('enrolled-students-' . $schedule->course->code . '-' . $schedule->day . '.pdf');
    }

    // Students List Excel Export
    public function studentsListExcel(Schedule $schedule)
    {
        $schedule->load([
            'enrollments.student.user',
            'course',
            'section'
        ]);

        return Excel::download(
            new \App\Exports\ScheduleStudentsExport($schedule->id),
            'enrolled-students-' . $schedule->course->code . '-' . $schedule->day . '.xlsx'
        );
    }

    // Students List Word Export
    public function studentsListWord(Schedule $schedule)
    {
        $schedule->load([
            'enrollments.student.user',
            'course',
            'faculty.user',
            'room',
            'semester.academicYear',
            'section'
        ]);

        $phpWord = new PhpWord();

        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Aklan Catholic College');
        $properties->setTitle('Enrolled Students List');

        $section = $phpWord->addSection();

        // Add Logo
        $logoPath = public_path('assets/logo.png');
        if (file_exists($logoPath)) {
            $section->addImage(
                $logoPath,
                [
                    'width' => 80,
                    'height' => 80,
                    'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
                ]
            );
            $section->addTextBreak(0.5);
        }

        // Header
        $section->addText(
            'AKLAN CATHOLIC COLLEGE',
            ['name' => 'Arial', 'size' => 18, 'bold' => true, 'color' => '1e40af'],
            ['alignment' => 'center']
        );
        $section->addText(
            'Pro Deo Et Patria',
            ['name' => 'Arial', 'size' => 10, 'italic' => true, 'color' => '059669'],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        $section->addText(
            'ENROLLED STUDENTS LIST',
            ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '059669'],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        // Schedule Info
        $infoTable = $section->addTable(['borderSize' => 0, 'cellMargin' => 50]);
        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Course:', ['bold' => true, 'size' => 10]);
        $infoTable->addCell(4000)->addText($schedule->course->code . ' - ' . $schedule->course->name, ['size' => 10]);

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Section:', ['bold' => true, 'size' => 10]);
        $infoTable->addCell(4000)->addText($schedule->section->name, ['size' => 10]);

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Faculty:', ['bold' => true, 'size' => 10]);
        $infoTable->addCell(4000)->addText($schedule->faculty->user->name, ['size' => 10]);

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Schedule:', ['bold' => true, 'size' => 10]);
        $infoTable->addCell(4000)->addText(
            $schedule->day . ' ' .
                date('g:i A', strtotime($schedule->start_time)) . ' - ' .
                date('g:i A', strtotime($schedule->end_time)),
            ['size' => 10]
        );

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Room:', ['bold' => true, 'size' => 10]);
        $infoTable->addCell(4000)->addText($schedule->room->code, ['size' => 10]);

        $section->addTextBreak(1);

        // Students Table
        $section->addText(
            'Total Enrolled: ' . $schedule->enrollments->count() . ' / ' . $schedule->max_students,
            ['name' => 'Arial', 'size' => 11, 'bold' => true]
        );
        $section->addTextBreak(0.5);

        $table = $section->addTable(['borderSize' => 6, 'cellMargin' => 80]);

        // Header row
        $table->addRow();
        $table->addCell(1500)->addText('Student ID', ['bold' => true, 'size' => 9]);
        $table->addCell(3000)->addText('Name', ['bold' => true, 'size' => 9]);
        $table->addCell(2500)->addText('Email', ['bold' => true, 'size' => 9]);
        $table->addCell(1000)->addText('Year Level', ['bold' => true, 'size' => 9]);
        $table->addCell(1500)->addText('Enrolled Date', ['bold' => true, 'size' => 9]);

        // Data rows
        foreach ($schedule->enrollments as $enrollment) {
            $table->addRow();
            $table->addCell(1500)->addText($enrollment->student->student_id, ['size' => 9]);
            $table->addCell(3000)->addText($enrollment->student->user->name, ['size' => 9]);
            $table->addCell(2500)->addText($enrollment->student->user->email, ['size' => 9]);
            $table->addCell(1000)->addText('Year ' . $enrollment->student->year_level, ['size' => 9]);
            $table->addCell(1500)->addText(
                $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A',
                ['size' => 9]
            );
        }

        $filename = 'enrolled-students-' . $schedule->course->code . '-' . $schedule->day . '.docx';
        $tempFile = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
