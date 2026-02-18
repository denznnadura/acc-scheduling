<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Semester;
use App\Models\Faculty;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\ScheduleExport;
use App\Exports\FacultyLoadExport;
use App\Exports\RoomUtilizationExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ReportController extends Controller
{
    public function index()
    {
        $semesters = Semester::with('academicYear')->where('is_active', true)->get();
        return view('reports.index', compact('semesters'));
    }

    public function schedulePdf(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $schedules = Schedule::with(['section.program', 'course', 'faculty.user', 'room', 'semester'])
            ->where('semester_id', $semesterId)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $pdf = Pdf::loadView('reports.schedule-pdf', compact('schedules', 'semester'));

        return $pdf->download('schedule-' . $semester->name . '.pdf');
    }

    public function facultyLoad(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $facultyLoads = Faculty::with([
            'user',
            'department',
            'schedules' => function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId)
                    ->where('status', 'active')
                    ->with(['course', 'section', 'room']);
            }
        ])
            ->where('is_active', true)
            ->get();

        return view('reports.faculty-load', compact('facultyLoads', 'semester'));
    }

    public function facultyLoadPdf(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $facultyLoads = Faculty::with([
            'user',
            'department',
            'schedules' => function ($query) use ($semesterId) {
                $query->where('semester_id', $semesterId)
                    ->where('status', 'active')
                    ->with(['course', 'section', 'room']);
            }
        ])
            ->where('is_active', true)
            ->get();

        $pdf = Pdf::loadView('reports.faculty-load-pdf', [
            'facultyLoads' => $facultyLoads,
            'semester' => $semester,
        ]);

        return $pdf->download('faculty-load-report-' . $semester->name . '-' . now()->format('Y-m-d') . '.pdf');
    }

    public function roomUtilization(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $rooms = Room::withCount(['schedules' => function ($q) use ($semesterId) {
            $q->where('semester_id', $semesterId)
                ->where('status', 'active');
        }])
            ->with(['schedules' => function ($q) use ($semesterId) {
                $q->where('semester_id', $semesterId)
                    ->where('status', 'active')
                    ->with(['course', 'section', 'faculty.user']);
            }])
            ->get();

        return view('reports.room-utilization', compact('rooms', 'semester'));
    }
    public function roomUtilizationPdf(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $rooms = Room::withCount(['schedules' => function ($q) use ($semesterId) {
            $q->where('semester_id', $semesterId)
                ->where('status', 'active');
        }])
            ->where('is_active', true)
            ->get();

        $pdf = Pdf::loadView('reports.room-utilization-pdf', [
            'rooms' => $rooms,
            'semester' => $semester,
        ]);

        return $pdf->download('room-utilization-report-' . $semester->name . '-' . now()->format('Y-m-d') . '.pdf');
    }
    // Schedule Excel
    public function scheduleExcel(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = Semester::findOrFail($semesterId);

        return Excel::download(
            new ScheduleExport($semesterId),
            'schedule-' . $semester->name . '.xlsx'
        );
    }

    // Faculty Load Excel
    public function facultyLoadExcel(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = Semester::findOrFail($semesterId);

        return Excel::download(
            new FacultyLoadExport($semesterId),
            'faculty-load-' . $semester->name . '.xlsx'
        );
    }

    // Room Utilization Excel
    public function roomUtilizationExcel(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = Semester::findOrFail($semesterId);

        return Excel::download(
            new RoomUtilizationExport($semesterId),
            'room-utilization-' . $semester->name . '.xlsx'
        );
    }
    public function scheduleView(Request $request)
    {
        $semesterId = $request->input('semester_id');

        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $schedules = Schedule::with(['section.program', 'course', 'faculty.user', 'room', 'semester'])
            ->where('semester_id', $semesterId)
            ->where('status', 'active')
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('reports.schedule-view', compact('schedules', 'semester'));
    }


    // Schedule Word Export (with logo)
    public function scheduleWord(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $schedules = Schedule::with(['section.program', 'course', 'faculty.user', 'room'])
            ->where('semester_id', $semesterId)
            ->where('status', 'active')
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $phpWord = new PhpWord();

        // Document properties
        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Aklan Catholic College');
        $properties->setCompany('ACC');
        $properties->setTitle('Schedule Report');
        $properties->setDescription('Class Schedule Report');

        $section = $phpWord->addSection();

        // Add Logo (centered)
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
        $section->addText(
            'Kalibo, Aklan, Philippines',
            ['name' => 'Arial', 'size' => 9, 'color' => '666666'],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        $section->addText(
            'CLASS SCHEDULE REPORT',
            ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '059669'],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        // Info
        $section->addText(
            "Semester: {$semester->name} | Academic Year: {$semester->academicYear->code}",
            ['name' => 'Arial', 'size' => 10],
            ['alignment' => 'center']
        );
        $section->addText(
            'Generated: ' . now()->format('F d, Y g:i A'),
            ['name' => 'Arial', 'size' => 9, 'color' => '666666'],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        // Table
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => 'e5e7eb',
            'cellMargin' => 80,
            'alignment' => 'center'
        ]);

        // Header row
        $table->addRow(400);
        $table->addCell(1500)->addText('Course', ['bold' => true, 'size' => 9]);
        $table->addCell(1200)->addText('Section', ['bold' => true, 'size' => 9]);
        $table->addCell(2000)->addText('Faculty', ['bold' => true, 'size' => 9]);
        $table->addCell(1000)->addText('Room', ['bold' => true, 'size' => 9]);
        $table->addCell(1000)->addText('Day', ['bold' => true, 'size' => 9]);
        $table->addCell(1500)->addText('Time', ['bold' => true, 'size' => 9]);
        $table->addCell(1000)->addText('Type', ['bold' => true, 'size' => 9]);
        $table->addCell(600)->addText('Units', ['bold' => true, 'size' => 9]);

        // Data rows
        foreach ($schedules as $schedule) {
            $table->addRow();
            $table->addCell(1500)->addText($schedule->course->code, ['size' => 9]);
            $table->addCell(1200)->addText($schedule->section->name, ['size' => 9]);
            $table->addCell(2000)->addText($schedule->faculty->user->name, ['size' => 9]);
            $table->addCell(1000)->addText($schedule->room->code, ['size' => 9]);
            $table->addCell(1000)->addText($schedule->day, ['size' => 9]);
            $table->addCell(1500)->addText(
                date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                ['size' => 9]
            );
            $table->addCell(1000)->addText(ucfirst($schedule->type), ['size' => 9]);
            $table->addCell(600)->addText($schedule->course->units, ['size' => 9]);
        }

        $filename = 'schedule-report-' . $semester->name . '.docx';
        $tempFile = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    // Faculty Load Word Export (with logo)
    public function facultyLoadWord(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $facultyLoads = Faculty::with([
            'user',
            'department',
            'schedules' => function ($query) use ($semesterId) {
                $query->where('semester_id', $semesterId)
                    ->where('status', 'active')
                    ->with(['course', 'section', 'room']);
            }
        ])->where('is_active', true)->get();

        $phpWord = new PhpWord();

        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Aklan Catholic College');
        $properties->setTitle('Faculty Load Report');

        $section = $phpWord->addSection();

        // Add Logo (centered)
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
            'FACULTY LOAD REPORT',
            ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '059669'],
            ['alignment' => 'center']
        );

        $section->addText(
            "Semester: {$semester->name} | Academic Year: {$semester->academicYear->code}",
            ['name' => 'Arial', 'size' => 10],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        foreach ($facultyLoads as $faculty) {
            $totalUnits = $faculty->schedules->sum(fn($s) => $s->course->units);
            $totalPreps = $faculty->schedules->unique('course_id')->count();

            // Faculty name
            $section->addText(
                $faculty->user->name,
                ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '1e40af']
            );
            $section->addText(
                "{$faculty->employee_id} | {$faculty->department->name} | Units: {$totalUnits}/{$faculty->max_units} | Preps: {$totalPreps}/{$faculty->max_preparations}",
                ['name' => 'Arial', 'size' => 9, 'color' => '666666']
            );

            $section->addTextBreak(0.5);

            if ($faculty->schedules->count() > 0) {
                $table = $section->addTable(['borderSize' => 6, 'cellMargin' => 80]);

                $table->addRow();
                $table->addCell(1500)->addText('Course', ['bold' => true, 'size' => 9]);
                $table->addCell(1000)->addText('Section', ['bold' => true, 'size' => 9]);
                $table->addCell(1000)->addText('Day', ['bold' => true, 'size' => 9]);
                $table->addCell(1500)->addText('Time', ['bold' => true, 'size' => 9]);
                $table->addCell(800)->addText('Room', ['bold' => true, 'size' => 9]);
                $table->addCell(600)->addText('Units', ['bold' => true, 'size' => 9]);

                foreach ($faculty->schedules as $schedule) {
                    $table->addRow();
                    $table->addCell(1500)->addText($schedule->course->code, ['size' => 9]);
                    $table->addCell(1000)->addText($schedule->section->name, ['size' => 9]);
                    $table->addCell(1000)->addText($schedule->day, ['size' => 9]);
                    $table->addCell(1500)->addText(
                        date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)),
                        ['size' => 9]
                    );
                    $table->addCell(800)->addText($schedule->room->code, ['size' => 9]);
                    $table->addCell(600)->addText($schedule->course->units, ['size' => 9]);
                }
            }

            $section->addTextBreak(1);
        }

        $filename = 'faculty-load-report-' . $semester->name . '.docx';
        $tempFile = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    // Room Utilization Word Export (with logo)
    public function roomUtilizationWord(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = Semester::with('academicYear')->findOrFail($semesterId);

        $rooms = Room::withCount(['schedules' => function ($q) use ($semesterId) {
            $q->where('semester_id', $semesterId)->where('status', 'active');
        }])->where('is_active', true)->get();

        $phpWord = new PhpWord();

        $properties = $phpWord->getDocInfo();
        $properties->setCreator('Aklan Catholic College');
        $properties->setTitle('Room Utilization Report');

        $section = $phpWord->addSection();

        // Add Logo (centered)
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
            'ROOM UTILIZATION REPORT',
            ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '059669'],
            ['alignment' => 'center']
        );

        $section->addText(
            "Semester: {$semester->name} | Academic Year: {$semester->academicYear->code}",
            ['name' => 'Arial', 'size' => 10],
            ['alignment' => 'center']
        );

        $section->addTextBreak(1);

        // Table
        $table = $section->addTable(['borderSize' => 6, 'cellMargin' => 80]);

        $table->addRow();
        $table->addCell(1000)->addText('Code', ['bold' => true, 'size' => 9]);
        $table->addCell(2000)->addText('Room Name', ['bold' => true, 'size' => 9]);
        $table->addCell(1500)->addText('Building', ['bold' => true, 'size' => 9]);
        $table->addCell(1200)->addText('Type', ['bold' => true, 'size' => 9]);
        $table->addCell(800)->addText('Capacity', ['bold' => true, 'size' => 9]);
        $table->addCell(800)->addText('Schedules', ['bold' => true, 'size' => 9]);
        $table->addCell(1000)->addText('Utilization', ['bold' => true, 'size' => 9]);

        foreach ($rooms as $room) {
            $maxSlots = 50;
            $utilization = $maxSlots > 0 ? round(($room->schedules_count / $maxSlots) * 100) : 0;

            $table->addRow();
            $table->addCell(1000)->addText($room->code, ['size' => 9, 'bold' => true]);
            $table->addCell(2000)->addText($room->name, ['size' => 9]);
            $table->addCell(1500)->addText($room->building, ['size' => 9]);
            $table->addCell(1200)->addText(ucwords(str_replace('_', ' ', $room->type)), ['size' => 9]);
            $table->addCell(800)->addText($room->capacity, ['size' => 9]);
            $table->addCell(800)->addText($room->schedules_count, ['size' => 9]);
            $table->addCell(1000)->addText($utilization . '%', ['size' => 9, 'bold' => true]);
        }

        $filename = 'room-utilization-report-' . $semester->name . '.docx';
        $tempFile = storage_path('app/temp/' . $filename);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
