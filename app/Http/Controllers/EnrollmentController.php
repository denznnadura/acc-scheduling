<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function adminIndex(Request $request)
    {
        $currentSemester = Semester::where('is_active', true)->first();

        // Ginawa nating grouped ang query para hindi paulit-ulit ang student sa table
        $query = Enrollment::with(['student.user', 'student.section'])
            ->select('student_id', 'semester_id', DB::raw('MAX(id) as id'))
            ->where('semester_id', $currentSemester->id ?? null)
            ->where('status', 'enrolled')
            ->groupBy('student_id', 'semester_id');

        if ($request->filled('section_id')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('section_id', $request->section_id);
            });
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $enrollments = $query->paginate(20);

        $sections = Section::with('program')->where('is_active', true)->get();
        $students = Student::with(['user', 'section'])->where('is_active', true)->get();
        $schedules = Schedule::with(['course', 'section', 'faculty.user'])
            ->where('semester_id', $currentSemester->id ?? null)
            ->where('status', 'active')
            ->get();

        return view('admin.enrollments.index', compact('enrollments', 'sections', 'students', 'schedules', 'currentSemester'));
    }

    // Bagong function para makuha ang schedule details sa Modal
    public function getStudentSchedule($studentId)
    {
        $currentSemester = Semester::where('is_active', true)->first();
        
        $schedules = Enrollment::with(['schedule.course', 'schedule.faculty.user', 'schedule.room'])
            ->where('student_id', $studentId)
            ->where('semester_id', $currentSemester->id)
            ->where('status', 'enrolled')
            ->get();

        return response()->json($schedules);
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'schedule_id' => 'nullable|exists:schedules,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $currentSemester = Semester::where('is_active', true)->first();

        if (!$currentSemester) {
            return back()->withErrors(['error' => 'No active semester found.']);
        }

        $sectionSchedules = Schedule::where('section_id', $student->section_id)
            ->where('semester_id', $currentSemester->id)
            ->where('status', 'active')
            ->get();

        if ($sectionSchedules->isEmpty()) {
            return back()->withErrors(['error' => 'No schedules found for this student\'s section.']);
        }

        DB::beginTransaction();
        try {
            $enrolledCount = 0;
            $skippedCount = 0;

            foreach ($sectionSchedules as $schedule) {
                $alreadyEnrolled = Enrollment::where('student_id', $student->id)
                    ->where('schedule_id', $schedule->id)
                    ->where('status', 'enrolled')
                    ->exists();

                if ($alreadyEnrolled || $schedule->enrolled_students >= $schedule->max_students) {
                    $skippedCount++;
                    continue;
                }

                Enrollment::create([
                    'student_id' => $student->id,
                    'schedule_id' => $schedule->id,
                    'semester_id' => $currentSemester->id,
                    'status' => 'enrolled',
                    'enrolled_at' => now(),
                ]);

                $schedule->increment('enrolled_students');
                $enrolledCount++;
            }

            if ($enrolledCount === 0) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Student is already enrolled in all available subjects or schedules are full.']);
            }

            DB::commit();
            
            $msg = "Successfully enrolled student in {$enrolledCount} subjects.";
            if ($skippedCount > 0) {
                $msg .= " ({$skippedCount} subjects were skipped).";
            }

            return back()->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Enrollment failed: ' . $e->getMessage()]);
        }
    }

    public function adminDestroy(Enrollment $enrollment)
    {
        DB::beginTransaction();
        try {
            $schedule = $enrollment->schedule;

            $enrollment->update([
                'status' => 'dropped',
                'dropped_at' => now(),
            ]);

            $schedule->decrement('enrolled_students');

            DB::commit();
            return back()->with('success', 'Student enrollment dropped successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to drop enrollment.']);
        }
    }

    public function index()
    {
        $student = auth()->user()->student;

        if (!$student) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Student profile not found.']);
        }

        $currentSemester = Semester::where('is_active', true)->first();

        if (!$currentSemester) {
            return redirect()->route('dashboard')->withErrors(['error' => 'No active semester found.']);
        }

        $enrollments = Enrollment::with(['schedule.course', 'schedule.faculty.user', 'schedule.room', 'schedule.section'])
            ->where('student_id', $student->id)
            ->where('semester_id', $currentSemester->id)
            ->where('status', 'enrolled')
            ->get();

        return view('enrollments.index', compact('enrollments', 'currentSemester', 'student'));
    }
}