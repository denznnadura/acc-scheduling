{{-- resources/views/schedules/students.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Schedule Students</x-slot>
    <x-slot name="breadcrumb">Schedules / Students</x-slot>

    <style>
        .students-container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .back-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 20px;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .back-btn:hover {
            border-color: var(--acc-primary);
            color: var(--acc-primary);
        }

        .schedule-info-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .schedule-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-label {
            font-size: 11px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 600;
        }

        .course-badge {
            background: var(--acc-primary);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
        }

        .students-table-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .students-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
        }

        .students-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .students-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .students-table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge.active {
            background: #f0fdf4;
            color: #059669;
        }

        .badge.inactive {
            background: #f9fafb;
            color: #6b7280;
        }

        .badge.enrolled {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge.dropped {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
        }

        .empty-state i {
            font-size: 48px;
            color: var(--text-tertiary);
            opacity: 0.3;
            margin-bottom: 16px;
        }

        .student-count {
            padding: 16px;
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-light);
            font-size: 13px;
            color: var(--text-tertiary);
            font-weight: 600;
        }

        .action-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .action-btn i {
            font-size: 16px;
        }
    </style>

    <div class="students-container">
        <!-- Header -->
        <div class="page-header">
            <h1>Enrolled Students</h1>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('schedules.index') }}" class="back-btn">
                    <i class='bx bx-arrow-back'></i>
                    Back
                </a>
            </div>
        </div>


        <!-- Schedule Info -->
        <div class="schedule-info-card">
            <div class="schedule-info-grid">
                <div class="info-item">
                    <span class="info-label">Course</span>
                    <span class="course-badge">{{ $schedule->course->code }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Section</span>
                    <span class="info-value">{{ $schedule->section->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Faculty</span>
                    <span class="info-value">{{ $schedule->faculty->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Room</span>
                    <span class="info-value">{{ $schedule->room->code }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Schedule</span>
                    <span class="info-value">
                        {{ $schedule->day }}
                        {{ date('g:i A', strtotime($schedule->start_time)) }} -
                        {{ date('g:i A', strtotime($schedule->end_time)) }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Semester</span>
                    <span class="info-value">{{ $schedule->semester->name }}
                        ({{ $schedule->semester->academicYear->code }})</span>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="students-table-card">
            <div class="student-count">
                Total Students Enrolled: <strong>{{ $schedule->enrollments->count() }}</strong> /
                {{ $schedule->max_students }}
            </div>

            <table class="students-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Year Level</th>
                        <th>Enrollment Status</th>
                        <th>Enrolled Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedule->enrollments as $enrollment)
                        <tr>
                            <td><strong>{{ $enrollment->student->student_id }}</strong></td>
                            <td>{{ $enrollment->student->user->name }}</td>
                            <td>{{ $enrollment->student->user->email }}</td>
                            <td>Year {{ $enrollment->student->year_level }}</td>
                            <td>
                                <span class="badge {{ $enrollment->status === 'enrolled' ? 'enrolled' : 'dropped' }}">
                                    <i
                                        class='bx bx-{{ $enrollment->status === 'enrolled' ? 'check-circle' : 'x-circle' }}'></i>
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </td>
                            <td>{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class='bx bx-user-x'></i>
                                    <div
                                        style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                                        No Students Enrolled
                                    </div>
                                    <div style="font-size: 13px; color: var(--text-tertiary);">
                                        There are no students enrolled in this schedule yet
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
