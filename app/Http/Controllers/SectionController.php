<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Program;
use App\Models\Semester;
use App\Models\Faculty;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with(['program', 'semester', 'adviser'])->paginate(15);
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $programs = Program::where('is_active', true)->get();
        $semesters = Semester::with('academicYear')->where('is_active', true)->get();
        $faculty = Faculty::with('user')->where('is_active', true)->get();
        return view('sections.create', compact('programs', 'semesters', 'faculty'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'semester_id' => 'required|exists:semesters,id',
            'name' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:6',
            'capacity' => 'required|integer|min:1|max:100',
            'adviser_id' => 'nullable|exists:faculty,id',
            'is_active' => 'boolean',
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    public function edit(Section $section)
    {
        $programs = Program::where('is_active', true)->get();
        $semesters = Semester::with('academicYear')->where('is_active', true)->get();
        $faculty = Faculty::with('user')->where('is_active', true)->get();
        return view('sections.edit', compact('section', 'programs', 'semesters', 'faculty'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'semester_id' => 'required|exists:semesters,id',
            'name' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:6',
            'capacity' => 'required|integer|min:1|max:100',
            'adviser_id' => 'nullable|exists:faculty,id',
            'is_active' => 'boolean',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }
}
