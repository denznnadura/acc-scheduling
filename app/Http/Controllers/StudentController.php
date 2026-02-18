<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use App\Models\Program;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentScheduleExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'program', 'section'])->paginate(15);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $programs = Program::where('is_active', true)->get();
        $sections = Section::with('program')->where('is_active', true)->get();
        return view('students.create', compact('programs', 'sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'program_id' => 'required|exists:programs,id',
            'section_id' => 'required|exists:sections,id',
            'student_id' => 'required|string|unique:students,student_id',
            'year_level' => 'required|integer|min:1|max:6',
            'status' => 'required|in:regular,irregular,probation',
            'enrollment_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $studentRole = Role::where('name', 'Student')->first();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id,
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'program_id' => $validated['program_id'],
                'section_id' => $validated['section_id'],
                'student_id' => $validated['student_id'],
                'year_level' => $validated['year_level'],
                'status' => $validated['status'],
                'enrollment_date' => $validated['enrollment_date'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student created successfully. Default password: password');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create student: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Student $student)
    {
        $programs = Program::where('is_active', true)->get();
        $sections = Section::with('program')->where('is_active', true)->get();
        return view('students.edit', compact('student', 'programs', 'sections'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'program_id' => 'required|exists:programs,id',
            'section_id' => 'required|exists:sections,id',
            'student_id' => 'required|string|unique:students,student_id,' . $student->id,
            'year_level' => 'required|integer|min:1|max:6',
            'status' => 'required|in:regular,irregular,probation',
            'enrollment_date' => 'required|date',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $student->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            $student->update([
                'program_id' => $validated['program_id'],
                'section_id' => $validated['section_id'],
                'student_id' => $validated['student_id'],
                'year_level' => $validated['year_level'],
                'status' => $validated['status'],
                'enrollment_date' => $validated['enrollment_date'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update student: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Student $student)
    {
        DB::beginTransaction();
        try {
            $user = $student->user;
            $student->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to delete student.']);
        }
    }


    // Student Schedule PDF
    public function schedulePdf(Student $student)
    {
        $student->load([
            'user',
            'program',
            'section.schedules' => function ($query) {
                $query->where('status', 'active')
                    ->with(['course', 'faculty.user', 'room', 'semester']);
            }
        ]);

        $pdf = Pdf::loadView('students.schedule-pdf', compact('student'));
        return $pdf->download('student-schedule-' . $student->student_id . '.pdf');
    }

    // Student Schedule Excel
    public function scheduleExcel(Student $student)
    {
        return Excel::download(
            new StudentScheduleExport($student->id),
            'student-schedule-' . $student->student_id . '.xlsx'
        );
    }

    // Student Schedule Word
    public function scheduleWord(Student $student)
    {
        $student->load([
            'user',
            'program',
            'section.schedules' => function ($query) {
                $query->where('status', 'active')
                    ->with(['course', 'faculty.user', 'room', 'semester']);
            }
        ]);

        $phpWord = new PhpWord();

        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Aklan Catholic College');
        $properties->setTitle('Student Schedule');

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
            'STUDENT SCHEDULE',
            ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '059669'],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        // Student Info
        $section->addText('STUDENT INFORMATION', ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '1e40af']);
        $section->addTextBreak(0.5);

        $studentInfoTable = $section->addTable(['borderSize' => 0, 'cellMargin' => 50]);
        $studentInfoTable->addRow();
        $studentInfoTable->addCell(2000)->addText('Student ID:', ['bold' => true, 'size' => 10]);
        $studentInfoTable->addCell(4000)->addText($student->student_id, ['size' => 10]);

        $studentInfoTable->addRow();
        $studentInfoTable->addCell(2000)->addText('Name:', ['bold' => true, 'size' => 10]);
        $studentInfoTable->addCell(4000)->addText($student->user->name, ['size' => 10]);

        $studentInfoTable->addRow();
        $studentInfoTable->addCell(2000)->addText('Program:', ['bold' => true, 'size' => 10]);
        $studentInfoTable->addCell(4000)->addText($student->program->name, ['size' => 10]);

        $studentInfoTable->addRow();
        $studentInfoTable->addCell(2000)->addText('Section:', ['bold' => true, 'size' => 10]);
        $studentInfoTable->addCell(4000)->addText($student->section->name, ['size' => 10]);

        $studentInfoTable->addRow();
        $studentInfoTable->addCell(2000)->addText('Year Level:', ['bold' => true, 'size' => 10]);
        $studentInfoTable->addCell(4000)->addText($student->year_level, ['size' => 10]);

        $section->addTextBreak(1);

        // Schedule Table
        $section->addText('CLASS SCHEDULE', ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '1e40af']);
        $section->addTextBreak(0.5);

        $table = $section->addTable(['borderSize' => 6, 'cellMargin' => 80]);

        // Header row
        $table->addRow();
        $table->addCell(1500)->addText('Course Code', ['bold' => true, 'size' => 9]);
        $table->addCell(2500)->addText('Course Name', ['bold' => true, 'size' => 9]);
        $table->addCell(2000)->addText('Faculty', ['bold' => true, 'size' => 9]);
        $table->addCell(1000)->addText('Day', ['bold' => true, 'size' => 9]);
        $table->addCell(1500)->addText('Time', ['bold' => true, 'size' => 9]);
        $table->addCell(800)->addText('Room', ['bold' => true, 'size' => 9]);
        $table->addCell(600)->addText('Units', ['bold' => true, 'size' => 9]);

        // Data rows
        foreach ($student->section->schedules as $schedule) {
            $table->addRow();
            $table->addCell(1500)->addText($schedule->course->code, ['size' => 9]);
            $table->addCell(2500)->addText($schedule->course->name, ['size' => 9]);
            $table->addCell(2000)->addText($schedule->faculty->user->name, ['size' => 9]);
            $table->addCell(1000)->addText($schedule->day, ['size' => 9]);
            $table->addCell(1500)->addText(
                date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                ['size' => 9]
            );
            $table->addCell(800)->addText($schedule->room->code, ['size' => 9]);
            $table->addCell(600)->addText($schedule->course->units, ['size' => 9]);
        }

        $filename = 'student-schedule-' . $student->student_id . '.docx';
        $tempFile = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
