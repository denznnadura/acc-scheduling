<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faculty Load Report - Aklan Catholic College</title>
    <style>
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

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1e40af;
        }

        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 15px;
        }

        .school-logo {
            width: 70px;
            height: 70px;
        }

        .school-info {
            text-align: left;
            padding-left: 15px;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 2px;
            text-transform: uppercase;
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
        }

        .report-title {
            font-size: 18px;
            font-weight: 700;
            color: #059669;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
            text-align: center;
        }

        .header-info {
            font-size: 11px;
            color: #6b7280;
            background: #f9fafb;
            padding: 10px 20px;
            border-radius: 8px;
            display: block;
            margin: 10px auto;
            width: fit-content;
            text-align: center;
        }

        .header-info strong {
            color: #1f2937;
        }

        .faculty-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        .faculty-header {
            background-color: #1e40af;
            color: white;
            padding: 12px 15px;
            border-radius: 8px 8px 0 0;
        }

        .faculty-name {
            font-size: 14px;
            font-weight: 700;
        }

        .faculty-details {
            font-size: 9px;
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
            font-size: 8px;
            font-weight: 700;
            color: #374151;
            border: 1px solid #e5e7eb;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            font-size: 9px;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .course-code { font-weight: 700; color: #1e40af; }
        .section-name { font-weight: 600; color: #059669; }
        .units-cell { text-align: center; font-weight: 700; }

        .faculty-summary {
            background: #f9fafb;
            padding: 10px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e5e7eb;
            border-top: none;
        }

        .summary-item {
            display: inline-block;
            margin-right: 20px;
        }

        .summary-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .summary-value {
            font-size: 12px;
            font-weight: 700;
            color: #1e40af;
        }

        .overload-warning {
            float: right;
            background: #fef2f2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 9px;
        }

        .no-schedules {
            text-align: center;
            padding: 20px;
            color: #9ca3af;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .footer-contact { font-size: 8px; color: #6b7280; }
        .footer-copyright { font-size: 8px; color: #9ca3af; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 70px; border: none;">
                    @php
                        $logoPath = public_path('assets/logo.png');
                        $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
                    @endphp
                    @if ($logoData)
                        <img src="data:image/png;base64,{{ $logoData }}" class="school-logo">
                    @endif
                </td>
                <td class="school-info" style="border: none;">
                    <h1>Aklan Catholic College</h1>
                    <div class="motto">Pro Deo Et Patria</div>
                    <div class="address">
                        Kalibo, Aklan, Philippines<br>
                        Tel: (036) 268-5137 | Email: acc@aklan.edu.ph
                    </div>
                </td>
            </tr>
        </table>

        <div class="report-title">Faculty Load Report</div>

        <div class="header-info">
            <strong>Semester:</strong> {{ $semester->name ?? 'N/A' }} | 
            <strong>AY:</strong> {{ $semester->academicYear->code ?? 'N/A' }} | 
            <strong>Date:</strong> {{ now()->format('F d, Y g:i A') }}
        </div>
    </div>

    @forelse($facultyLoads as $faculty)
        <div class="faculty-section">
            <div class="faculty-header">
                <div class="faculty-name">{{ $faculty->user->name }}</div>
                <div class="faculty-details">
                    {{ $faculty->employee_id }} | {{ $faculty->department->name ?? 'N/A' }} | {{ ucwords(str_replace('_', ' ', $faculty->position)) }}
                </div>
            </div>

            @if ($faculty->schedules->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 12%;">Code</th>
                            <th style="width: 25%;">Course Name</th>
                            <th style="width: 10%;">Section</th>
                            <th style="width: 10%;">Day</th>
                            <th style="width: 20%;">Time</th>
                            <th style="width: 10%;">Room</th>
                            <th style="width: 8%;">Units</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalUnits = 0;
                            $preps = [];
                        @endphp
                        @foreach ($faculty->schedules as $schedule)
                            @php
                                $totalUnits += $schedule->course->units ?? 0;
                                $preps[] = $schedule->course_id;
                            @endphp
                            <tr>
                                <td class="course-code">{{ $schedule->course->code }}</td>
                                <td>{{ $schedule->course->name }}</td>
                                <td class="section-name">{{ $schedule->section->name }}</td>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</td>
                                <td>{{ $schedule->room->code }}</td>
                                <td class="units-cell">{{ $schedule->course->units }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="faculty-summary">
                    <div class="summary-item">
                        <span class="summary-label">Units:</span>
                        <span class="summary-value">{{ $totalUnits }} / {{ $faculty->max_units }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Preps:</span>
                        <span class="summary-value">{{ count(array_unique($preps)) }} / {{ $faculty->max_preparations }}</span>
                    </div>
                    
                    @if ($totalUnits > $faculty->max_units)
                        <div class="overload-warning">⚠ OVERLOAD</div>
                    @endif
                </div>
            @else
                <div class="no-schedules">No schedules assigned for this faculty member</div>
            @endif
        </div>
    @empty
        <div class="no-schedules" style="padding: 50px;">No faculty data available for this semester</div>
    @endforelse

    <div class="footer">
        <div class="footer-contact">Aklan Catholic College | Kalibo, Aklan, Philippines</div>
        <div class="footer-copyright">
            © {{ date('Y') }} System Generated Report | Valid without signature.
        </div>
    </div>
</body>
</html>