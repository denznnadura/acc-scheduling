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
    // ADMIN: Manage all enrollments
    public function adminIndex(Request $request)
    {
        $currentSemester = Semester::where('is_active', true)->first();

        $query = Enrollment::with(['student.user', 'student.section', 'schedule.course', 'schedule.faculty.user'])
            ->where('semester_id', $currentSemester->id ?? null);

        // Filters
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

    // ADMIN: Enroll student
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $schedule = Schedule::findOrFail($validated['schedule_id']);

        // Check if schedule belongs to student's section
        if ($schedule->section_id !== $student->section_id) {
            return back()->withErrors(['error' => 'This schedule does not belong to the student\'s section.']);
        }

        // Check if schedule is full
        if ($schedule->enrolled_students >= $schedule->max_students) {
            return back()->withErrors(['error' => 'This schedule is already full.']);
        }

        // Check if already enrolled
        $exists = Enrollment::where('student_id', $student->id)
            ->where('schedule_id', $schedule->id)
            ->where('status', 'enrolled')
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Student is already enrolled in this schedule.']);
        }

        DB::beginTransaction();
        try {
            Enrollment::create([
                'student_id' => $student->id,
                'schedule_id' => $schedule->id,
                'semester_id' => $schedule->semester_id,
                'status' => 'enrolled',
                'enrolled_at' => now(),
            ]);

            $schedule->increment('enrolled_students');

            DB::commit();
            return back()->with('success', 'Student enrolled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to enroll student: ' . $e->getMessage()]);
        }
    }

    // ADMIN: Drop student enrollment
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

    // STUDENT: View only their enrollments
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

        // Get student's enrollments
        $enrollments = Enrollment::with(['schedule.course', 'schedule.faculty.user', 'schedule.room', 'schedule.section'])
            ->where('student_id', $student->id)
            ->where('semester_id', $currentSemester->id)
            ->where('status', 'enrolled')
            ->get();

        return view('enrollments.index', compact('enrollments', 'currentSemester', 'student'));
    }
}
