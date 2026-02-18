<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Department;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with('department')->paginate(15);
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('programs.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|string|unique:programs,code|max:20',
            'name' => 'required|string|max:255',
            'type' => 'required|in:bachelor,diploma,certificate',
            'duration_years' => 'nullable|integer|min:1|max:10',
            'duration_months' => 'nullable|integer|min:1|max:60',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Program::create($validated);

        return redirect()->route('programs.index')->with('success', 'Program created successfully.');
    }

    public function edit(Program $program)
    {
        $departments = Department::where('is_active', true)->get();
        return view('programs.edit', compact('program', 'departments'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|string|max:20|unique:programs,code,' . $program->id,
            'name' => 'required|string|max:255',
            'type' => 'required|in:bachelor,diploma,certificate',
            'duration_years' => 'nullable|integer|min:1|max:10',
            'duration_months' => 'nullable|integer|min:1|max:60',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $program->update($validated);

        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('programs.index')->with('success', 'Program deleted successfully.');
    }
}
