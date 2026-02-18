{{-- resources/views/reports/schedule-pdf.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Class Schedule Report - Aklan Catholic College</title>
    <style>
        /* Professional PDF Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #1f2937;
            padding: 30px;
        }

        /* Header Section with Logo */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1e40af;
        }

        .header-top {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            gap: 20px;
        }

        .school-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .school-info {
            text-align: left;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
        }

        .header .motto {
            font-size: 10px;
            font-style: italic;
            color: #059669;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .header .address {
            font-size: 9px;
            color: #6b7280;
            line-height: 1.6;
        }

        .report-title {
            font-size: 18px;
            font-weight: 700;
            color: #059669;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-info {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.8;
            background: #f9fafb;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }

        .header-info strong {
            color: #1f2937;
            font-weight: 600;
        }

        .header-info div {
            margin: 3px 0;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        thead {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        th {
            padding: 12px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        th:last-child {
            border-right: none;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody tr:hover {
            background-color: #eff6ff;
        }

        td {
            padding: 10px 8px;
            font-size: 9px;
            color: #374151;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }

        td:first-child {
            font-weight: 700;
            color: #1e40af;
        }

        .course-cell {
            font-weight: 700;
            color: #1e40af;
        }

        .section-cell {
            font-weight: 600;
            color: #059669;
        }

        .type-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .type-lecture {
            background: #dbeafe;
            color: #1e40af;
        }

        .type-laboratory {
            background: #d1fae5;
            color: #059669;
        }

        /* Summary Section */
        .summary-section {
            margin-top: 25px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
        }

        .summary-title {
            font-size: 12px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .summary-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .summary-item {
            flex: 1;
            min-width: 150px;
        }

        .summary-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 20px;
            font-weight: 700;
            color: #1e40af;
        }

        /* Footer Section */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
        }

        .footer-stats {
            font-size: 11px;
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .footer-contact {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .footer-copyright {
            font-size: 9px;
            color: #9ca3af;
            font-style: italic;
        }

        /* Print Optimization */
        @media print {
            body {
                padding: 20px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            .summary-section {
                page-break-before: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- Header with Logo -->
    <div class="header">
        <div class="header-top">
            <img src="{{ public_path('assets/logo.png') }}" alt="ACC Logo" class="school-logo">
            <div class="school-info">
                <h1>Aklan Catholic College</h1>
                <div class="motto">Pro Deo Et Patria</div>
                <div class="address">
                    Kalibo, Aklan, Philippines<br>
                    Tel: (036) 268-5137 | Email: acc@aklan.edu.ph
                </div>
            </div>
        </div>

        <div class="report-title">Class Schedule Report</div>

        <div class="header-info">
            <div><strong>Semester:</strong> {{ $semester->name }}</div>
            <div><strong>Academic Year:</strong> {{ $semester->academicYear->code }}</div>
            <div><strong>Period:</strong> {{ $semester->start_date->format('M d, Y') }} -
                {{ $semester->end_date->format('M d, Y') }}</div>
            <div><strong>Generated:</strong> {{ now()->format('F d, Y g:i A') }}</div>
        </div>
    </div>

    <!-- Schedule Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Course</th>
                <th style="width: 12%;">Section</th>
                <th style="width: 20%;">Faculty</th>
                <th style="width: 10%;">Room</th>
                <th style="width: 12%;">Day</th>
                <th style="width: 18%;">Time</th>
                <th style="width: 8%;">Units</th>
                <th style="width: 8%;">Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="course-cell">{{ $schedule->course->code }}</td>
                    <td class="section-cell">{{ $schedule->section->name }}</td>
                    <td>{{ $schedule->faculty->user->name }}</td>
                    <td><strong>{{ $schedule->room->code }}</strong></td>
                    <td>{{ $schedule->day }}</td>
                    <td>
                        {{ date('g:i A', strtotime($schedule->start_time)) }} -
                        {{ date('g:i A', strtotime($schedule->end_time)) }}
                    </td>
                    <td style="text-align: center;"><strong>{{ $schedule->course->units }}</strong></td>
                    <td>
                        <span class="type-badge type-{{ $schedule->type }}">
                            {{ ucfirst($schedule->type) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #9ca3af; font-style: italic;">
                        No schedules found for this semester
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-title">Report Summary</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Total Schedules</div>
                <div class="summary-value">{{ $schedules->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Lecture Classes</div>
                <div class="summary-value">{{ $schedules->where('type', 'lecture')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Laboratory Classes</div>
                <div class="summary-value">{{ $schedules->where('type', 'laboratory')->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Active Sections</div>
                <div class="summary-value">{{ $schedules->pluck('section_id')->unique()->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-contact">
            Aklan Catholic College | Kalibo, Aklan, Philippines | www.aklancatholiccollege.edu.ph
        </div>
        <div class="footer-copyright">
            © {{ date('Y') }} Aklan Catholic College. All rights reserved. | Document is system-generated and valid
            without signature.
        </div>
    </div>
</body>

</html>
