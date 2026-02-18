{{-- resources/views/reports/room-utilization.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Room Utilization Report</x-slot>
    <x-slot name="breadcrumb">Reports / Room Utilization</x-slot>

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

        .utilization-table {
            width: 100%;
            border-collapse: collapse;
        }

        .utilization-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .utilization-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .utilization-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .utilization-table tbody tr {
            transition: background 0.2s;
        }

        .utilization-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .utilization-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            background: #dbeafe;
            color: #1e40af;
        }

        /* Progress Bar */
        .progress-bar-container {
            position: relative;
            width: 100%;
            height: 24px;
            background: #f3f4f6;
            border-radius: 12px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: white;
            transition: width 0.3s ease;
        }

        .progress-bar.low {
            background: linear-gradient(90deg, #059669 0%, #10b981 100%);
        }

        .progress-bar.medium {
            background: linear-gradient(90deg, #d97706 0%, #f59e0b 100%);
        }

        .progress-bar.high {
            background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%);
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

            .utilization-table thead th {
                padding: 10px 12px;
                font-size: 10px;
            }

            .utilization-table tbody td {
                padding: 12px;
                font-size: 12px;
            }
        }
    </style>

    <div class="report-container">
        <!-- Header -->
        <div class="page-header">
            <h1>Room Utilization Report</h1>
            <a href="{{ route('reports.index') }}" class="back-btn">
                <i class='bx bx-arrow-back'></i>
                Back to Reports
            </a>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-wrapper">
                <table class="utilization-table">
                    <thead>
                        <tr>
                            <th>Room Code</th>
                            <th>Room Name</th>
                            <th>Building</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Schedules</th>
                            <th>Utilization</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            @php
                                // Assuming max 50 schedule slots per week (5 days x 10 time slots)
                                $maxSlots = 50;
                                $utilization = $maxSlots > 0 ? round(($room->schedules_count / $maxSlots) * 100) : 0;

                                // Determine bar style
                                if ($utilization >= 80) {
                                    $barClass = 'high';
                                } elseif ($utilization >= 50) {
                                    $barClass = 'medium';
                                } else {
                                    $barClass = 'low';
                                }
                            @endphp
                            <tr>
                                <td><strong>{{ $room->code }}</strong></td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->building }}</td>
                                <td>
                                    <span class="type-badge">
                                        {{ ucwords(str_replace('_', ' ', $room->type)) }}
                                    </span>
                                </td>
                                <td>{{ $room->capacity }}</td>
                                <td><strong>{{ $room->schedules_count }}</strong></td>
                                <td>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar {{ $barClass }}"
                                            style="width: {{ $utilization }}%;">
                                            {{ $utilization }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 48px 20px;">
                                    <i class='bx bx-door-open'
                                        style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 12px; color: var(--text-tertiary);"></i>
                                    <strong style="color: var(--text-primary); font-size: 14px;">No Rooms
                                        Found</strong><br>
                                    <span style="color: var(--text-tertiary); font-size: 12px;">No room data available
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
