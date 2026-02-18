<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('academicYear')->paginate(15);
        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all();
        return view('semesters.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_start' => 'required|date',
            'enrollment_end' => 'required|date|after:enrollment_start',
            'is_active' => 'boolean',
        ]);

        Semester::create($validated);

        return redirect()->route('semesters.index')->with('success', 'Semester created successfully.');
    }

    public function edit(Semester $semester)
    {
        $academicYears = AcademicYear::all();
        return view('semesters.edit', compact('semester', 'academicYears'));
    }

    public function update(Request $request, Semester $semester)
    {
        $validated = $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_start' => 'required|date',
            'enrollment_end' => 'required|date|after:enrollment_start',
            'is_active' => 'boolean',
        ]);

        $semester->update($validated);

        return redirect()->route('semesters.index')->with('success', 'Semester updated successfully.');
    }

    public function activate(Semester $semester)
    {
        DB::beginTransaction();
        try {
            Semester::where('is_active', true)->update(['is_active' => false]);
            $semester->update(['is_active' => true]);

            DB::commit();
            return redirect()->route('semesters.index')->with('success', 'Semester activated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to activate semester.']);
        }
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semesters.index')->with('success', 'Semester deleted successfully.');
    }
}
