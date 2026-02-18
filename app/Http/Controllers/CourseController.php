<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('department')->paginate(15);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $courses = Course::where('is_active', true)->get();
        return view('courses.create', compact('departments', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|string|unique:courses,code|max:20',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'required|integer|min:1|max:10',
            'lecture_hours' => 'required|integer|min:0',
            'lab_hours' => 'required|integer|min:0',
            'type' => 'required|in:lecture,laboratory,lecture_lab',
            'prerequisite_ids' => 'nullable|array',
            'prerequisite_ids.*' => 'exists:courses,id',
            'is_active' => 'boolean',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $departments = Department::where('is_active', true)->get();
        $courses = Course::where('is_active', true)->where('id', '!=', $course->id)->get();
        return view('courses.edit', compact('course', 'departments', 'courses'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|string|max:20|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'units' => 'required|integer|min:1|max:10',
            'lecture_hours' => 'required|integer|min:0',
            'lab_hours' => 'required|integer|min:0',
            'type' => 'required|in:lecture,laboratory,lecture_lab',
            'prerequisite_ids' => 'nullable|array',
            'prerequisite_ids.*' => 'exists:courses,id',
            'is_active' => 'boolean',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
