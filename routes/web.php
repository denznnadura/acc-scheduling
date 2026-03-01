<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/portal/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('programs', ProgramController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('rooms', RoomController::class);
        Route::resource('semesters', SemesterController::class);
        Route::resource('faculty', FacultyController::class);
        Route::resource('students', StudentController::class);
        Route::resource('sections', SectionController::class);

        // Semester activation
        Route::post('semesters/{semester}/activate', [SemesterController::class, 'activate'])->name('semesters.activate');
        
        // Updated Faculty Load PDF Route to point to FacultyController
        Route::get('reports/faculty-load-pdf/{id?}', [FacultyController::class, 'downloadSchedulePdf'])->name('reports.faculty-load-pdf');
        
        Route::get('reports/room-utilization-pdf', [ReportController::class, 'roomUtilizationPdf'])->name('reports.room-utilization-pdf');
        
        // Excel exports
        Route::get('reports/schedule-excel', [ReportController::class, 'scheduleExcel'])->name('reports.schedule-excel');
        // Added the specific download route for Faculty Load
        Route::get('reports/faculty-load/download/{id}', [ReportController::class, 'downloadFacultyLoad'])->name('reports.faculty-load.download');
        Route::get('reports/faculty-load-excel', [ReportController::class, 'facultyLoadExcel'])->name('reports.faculty-load-excel');
        Route::get('reports/room-utilization-excel', [ReportController::class, 'roomUtilizationExcel'])->name('reports.room-utilization-excel');
        Route::get('reports/schedule-view', [ReportController::class, 'scheduleView'])->name('reports.schedule-view');
        
        // Word exports
        Route::get('reports/schedule-word', [ReportController::class, 'scheduleWord'])->name('reports.schedule-word');
        Route::get('reports/faculty-load-word', [ReportController::class, 'facultyLoadWord'])->name('reports.faculty-load-word');
        Route::get('reports/room-utilization-word', [ReportController::class, 'roomUtilizationWord'])->name('reports.room-utilization-word');

        Route::get('students/{student}/schedule-pdf', [StudentController::class, 'schedulePdf'])->name('students.schedule-pdf');
        Route::get('students/{student}/schedule-excel', [StudentController::class, 'scheduleExcel'])->name('students.schedule-excel');
        Route::get('students/{student}/schedule-word', [StudentController::class, 'scheduleWord'])->name('students.schedule-word');
    });

    // Admin Enrollment Management
    Route::get('admin/enrollments', [EnrollmentController::class, 'adminIndex'])->name('admin.enrollments.index');
    Route::post('admin/enrollments', [EnrollmentController::class, 'adminStore'])->name('admin.enrollments.store');
    Route::delete('admin/enrollments/{enrollment}', [EnrollmentController::class, 'adminDestroy'])->name('admin.enrollments.destroy');

    // Schedule routes (Admin and Faculty)
    Route::middleware(['role:Admin,Faculty'])->group(function () {
        Route::resource('schedules', ScheduleController::class);
        Route::post('schedules/check-availability', [ScheduleController::class, 'checkAvailability'])->name('schedules.check-availability');
        Route::get('schedules/{schedule}/students', [ScheduleController::class, 'viewStudents'])->name('schedules.students');
        Route::get('schedules/{schedule}/students-pdf', [ScheduleController::class, 'studentsListPdf'])->name('schedules.students-pdf');
        Route::get('schedules/{schedule}/students-excel', [ScheduleController::class, 'studentsListExcel'])->name('schedules.students-excel');
        Route::get('schedules/{schedule}/students-word', [ScheduleController::class, 'studentsListWord'])->name('schedules.students-word');

        Route::get('/full-schedule/pdf', [ScheduleController::class, 'downloadFullPdf'])->name('full.pdf');
        Route::get('/full-schedule/excel', [ScheduleController::class, 'downloadFullExcel'])->name('full.excel');
        Route::get('/full-schedule/word', [ScheduleController::class, 'downloadFullWord'])->name('full.word');
    });

    // Student routes
    Route::middleware(['role:Student'])->group(function () {
        Route::get('enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    });

    // Reports
    Route::middleware(['role:Admin,Faculty'])->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/schedule-pdf', [ReportController::class, 'schedulePdf'])->name('reports.schedule-pdf');
        Route::get('reports/faculty-load', [ReportController::class, 'facultyLoad'])->name('reports.faculty-load');
        Route::get('reports/room-utilization', [ReportController::class, 'roomUtilization'])->name('reports.room-utilization');
    });

    Route::get('/clear-all', function() {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return "Cache Cleared!";
    });
});

require __DIR__ . '/auth.php';