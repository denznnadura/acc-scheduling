<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FacultyController extends Controller
{
    public function index()
    {
        $faculty = Faculty::with(['user', 'department'])->paginate(15);
        return view('faculty.index', compact('faculty'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('faculty.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'employee_id' => 'required|string|unique:faculty,employee_id',
            'position' => 'required|in:full_time,part_time,visiting',
            'rank' => 'nullable|string',
            'specializations' => 'nullable|array',
            'max_units' => 'required|integer|min:1|max:30',
            'max_preparations' => 'required|integer|min:1|max:10',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $facultyRole = Role::where('name', 'Faculty')->first();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'),
                'role_id' => $facultyRole->id,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            Faculty::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'employee_id' => $validated['employee_id'],
                'position' => $validated['position'],
                'rank' => $validated['rank'] ?? null,
                'specializations' => $validated['specializations'] ?? null,
                'max_units' => $validated['max_units'],
                'max_preparations' => $validated['max_preparations'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            DB::commit();
            return redirect()->route('faculty.index')->with('success', 'Faculty created successfully. Default password: password');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create faculty: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Faculty $faculty)
    {
        $departments = Department::where('is_active', true)->get();
        return view('faculty.edit', compact('faculty', 'departments'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $faculty->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'employee_id' => 'required|string|unique:faculty,employee_id,' . $faculty->id,
            'position' => 'required|in:full_time,part_time,visiting',
            'rank' => 'nullable|string',
            'specializations' => 'nullable|array',
            'max_units' => 'required|integer|min:1|max:30',
            'max_preparations' => 'required|integer|min:1|max:10',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $faculty->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            $faculty->update([
                'department_id' => $validated['department_id'],
                'employee_id' => $validated['employee_id'],
                'position' => $validated['position'],
                'rank' => $validated['rank'] ?? null,
                'specializations' => $validated['specializations'] ?? null,
                'max_units' => $validated['max_units'],
                'max_preparations' => $validated['max_preparations'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            DB::commit();
            return redirect()->route('faculty.index')->with('success', 'Faculty updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update faculty: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Faculty $faculty)
    {
        DB::beginTransaction();
        try {
            $user = $faculty->user;
            $faculty->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('faculty.index')->with('success', 'Faculty deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete faculty.']);
        }
    }

    public function downloadSchedulePdf(Request $request, $id = null)
    {
        $semesterId = $request->get('semester_id');
        
        $semester = Semester::with('academicYear')->find($semesterId);

        if (!$semester) {
            $semester = Semester::with('academicYear')->where('is_active', true)->first();
        }

        $query = Faculty::with(['user', 'department', 'schedules' => function ($q) use ($semester) {
            $q->where('semester_id', $semester->id)
              ->with(['course', 'section', 'room']);
        }]);

        if ($id) {
            $facultyLoads = $query->where('id', $id)->get();
        } else {
            $facultyLoads = $query->whereHas('schedules', function ($q) use ($semester) {
                $q->where('semester_id', $semester->id);
            })->get();
        }

        $pdf = Pdf::loadView('reports.faculty-load-pdf', [
            'semester' => $semester,
            'facultyLoads' => $facultyLoads,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Faculty_Load_Report.pdf');
    }
}