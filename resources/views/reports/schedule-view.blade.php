{{-- resources/views/reports/schedule-view.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Schedule Report</x-slot>
    <x-slot name="breadcrumb">Reports / Schedule</x-slot>

    <style>
        /* Minimalist Report Page */
        .report-container {
            max-width: 1400px;
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
            gap: 16px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
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

        .back-btn i {
            font-size: 16px;
        }

        /* Info Card */
        .info-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #dbeafe;
            color: #1e40af;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 11px;
            color: var(--text-tertiary);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Table Card */
        .table-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .schedule-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .schedule-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .schedule-table tbody tr {
            transition: background 0.2s;
        }

        .schedule-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .schedule-table tbody tr:last-child td {
            border-bottom: none;
        }

        .course-code {
            font-weight: 700;
            color: #1e40af;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            background: #d1fae5;
            color: #065f46;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .type-lecture {
            background: #dbeafe;
            color: #1e40af;
        }

        .type-laboratory {
            background: #d1fae5;
            color: #059669;
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header h1 {
                font-size: 20px;
            }

            .back-btn {
                justify-content: center;
            }

            .schedule-table {
                font-size: 11px;
            }

            .schedule-table thead th,
            .schedule-table tbody td {
                padding: 8px;
            }
        }
    </style>

    <div class="report-container">
        <!-- Header -->
        <div class="page-header">
            <h1>Schedule Report</h1>
            <a href="{{ route('reports.index') }}" class="back-btn">
                <i class='bx bx-arrow-back'></i>
                Back to Reports
            </a>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-calendar'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Semester</div>
                        <div class="info-value">{{ $semester->name }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-calendar-alt'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Academic Year</div>
                        <div class="info-value">{{ $semester->academicYear->code }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-list-ul'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Total Schedules</div>
                        <div class="info-value">{{ $schedules->count() }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-time'></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Generated</div>
                        <div class="info-value">{{ now()->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-wrapper">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Faculty</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Units</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>
                                    <div class="course-code">{{ $schedule->course->code }}</div>
                                    <div style="font-size: 11px; color: var(--text-tertiary);">
                                        {{ $schedule->course->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="section-badge">{{ $schedule->section->name }}</span>
                                </td>
                                <td>{{ $schedule->faculty->user->name }}</td>
                                <td><strong>{{ $schedule->room->code }}</strong></td>
                                <td>{{ $schedule->day }}</td>
                                <td>
                                    {{ date('g:i A', strtotime($schedule->start_time)) }} -
                                    {{ date('g:i A', strtotime($schedule->end_time)) }}
                                </td>
                                <td>
                                    <span class="type-badge type-{{ $schedule->type }}">
                                        {{ ucfirst($schedule->type) }}
                                    </span>
                                </td>
                                <td style="text-align: center;"><strong>{{ $schedule->course->units }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 48px 20px;">
                                    <i class='bx bx-calendar-x'
                                        style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 12px; color: var(--text-tertiary);"></i>
                                    <strong style="color: var(--text-primary); font-size: 14px;">No Schedules
                                        Found</strong><br>
                                    <span style="color: var(--text-tertiary); font-size: 12px;">No schedules available
                                        for this semester</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
