{{-- resources/views/reports/faculty-load-pdf.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Faculty Load Report - Aklan Catholic College</title>
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

        /* Faculty Section */
        .faculty-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .faculty-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faculty-name {
            font-size: 14px;
            font-weight: 700;
        }

        .faculty-details {
            font-size: 9px;
            opacity: 0.9;
            margin-top: 3px;
        }

        .faculty-load-summary {
            text-align: right;
            font-size: 9px;
            font-weight: 600;
        }

        .load-item {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
            margin: 2px 0;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 10px 8px;
            font-size: 9px;
            color: #374151;
        }

        .course-code {
            font-weight: 700;
            color: #1e40af;
        }

        .section-name {
            font-weight: 600;
            color: #059669;
        }

        .units-cell {
            text-align: center;
            font-weight: 700;
            color: #1e40af;
        }

        /* Summary Box */
        .faculty-summary {
            background: #f9fafb;
            padding: 12px 15px;
            border-radius: 0 0 8px 8px;
            border-top: 2px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
        }

        .summary-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e40af;
        }

        .overload-warning {
            background: #fef2f2;
            color: #991b1b;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* No Data State */
        .no-schedules {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
            font-style: italic;
            background: #f9fafb;
        }

        /* Footer Section */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
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

            .faculty-section {
                page-break-inside: avoid;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- Header with Logo -->
    <div class="header">
        <div class="header-top">
            @php
                $logoPath = public_path('assets/logo.png');
                $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
            @endphp

            @if ($logoData)
                <img src="data:image/png;base64,{{ $logoData }}" alt="ACC Logo" class="school-logo">
            @else
                <div
                    style="width: 70px; height: 70px; background: #1e40af; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 24px;">
                    ACC
                </div>
            @endif

            <div class="school-info">
                <h1>Aklan Catholic College</h1>
                <div class="motto">Pro Deo Et Patria</div>
                <div class="address">
                    Kalibo, Aklan, Philippines<br>
                    Tel: (036) 268-5137 | Email: acc@aklan.edu.ph
                </div>
            </div>
        </div>

        <div class="report-title">Faculty Load Report</div>

        <div class="header-info">
            <div><strong>Semester:</strong> {{ $semester->name }}</div>
            <div><strong>Academic Year:</strong> {{ $semester->academicYear->code }}</div>
            <div><strong>Generated:</strong> {{ now()->format('F d, Y g:i A') }}</div>
        </div>
    </div>

    <!-- Faculty Load Sections -->
    @forelse($facultyLoads as $faculty)
        <div class="faculty-section">
            <!-- Faculty Header -->
            <div class="faculty-header">
                <div>
                    <div class="faculty-name">{{ $faculty->user->name }}</div>
                    <div class="faculty-details">
                        {{ $faculty->employee_id }} | {{ $faculty->department->name }} |
                        {{ ucwords(str_replace('_', ' ', $faculty->position)) }}
                    </div>
                </div>
                <div class="faculty-load-summary">
                    @php
                        $totalUnits = $faculty->schedules->sum(fn($s) => $s->course->units);
                        $totalPreps = $faculty->schedules->unique('course_id')->count();
                        $isOverload = $totalUnits > $faculty->max_units || $totalPreps > $faculty->max_preparations;
                    @endphp
                    <div class="load-item">Units: {{ $totalUnits }} / {{ $faculty->max_units }}</div>
                    <div class="load-item">Preps: {{ $totalPreps }} / {{ $faculty->max_preparations }}</div>
                </div>
            </div>

            <!-- Schedules Table -->
            @if ($faculty->schedules->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%;">Course Code</th>
                            <th style="width: 20%;">Course Name</th>
                            <th style="width: 12%;">Section</th>
                            <th style="width: 12%;">Day</th>
                            <th style="width: 18%;">Time</th>
                            <th style="width: 10%;">Room</th>
                            <th style="width: 8%;">Type</th>
                            <th style="width: 5%;">Units</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faculty->schedules as $schedule)
                            <tr>
                                <td class="course-code">{{ $schedule->course->code }}</td>
                                <td>{{ $schedule->course->name }}</td>
                                <td class="section-name">{{ $schedule->section->name }}</td>
                                <td>{{ $schedule->day }}</td>
                                <td>
                                    {{ date('g:i A', strtotime($schedule->start_time)) }} -
                                    {{ date('g:i A', strtotime($schedule->end_time)) }}
                                </td>
                                <td><strong>{{ $schedule->room->code }}</strong></td>
                                <td>{{ ucfirst($schedule->type) }}</td>
                                <td class="units-cell">{{ $schedule->course->units }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Summary -->
                <div class="faculty-summary">
                    <div>
                        <span class="summary-label">Total Classes:</span>
                        <span class="summary-value">{{ $faculty->schedules->count() }}</span>
                    </div>
                    <div>
                        <span class="summary-label">Total Units:</span>
                        <span class="summary-value">{{ $totalUnits }}</span>
                    </div>
                    <div>
                        <span class="summary-label">Total Preparations:</span>
                        <span class="summary-value">{{ $totalPreps }}</span>
                    </div>
                    @if ($isOverload)
                        <div class="overload-warning">
                            ⚠ OVERLOAD
                        </div>
                    @endif
                </div>
            @else
                <div class="no-schedules">
                    No schedules assigned for this faculty member
                </div>
            @endif
        </div>
    @empty
        <div class="no-schedules" style="padding: 50px;">
            No faculty data available for this semester
        </div>
    @endforelse

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
