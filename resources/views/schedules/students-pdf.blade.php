<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Enrolled Students - {{ $schedule->course->code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
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
        }

        .header .motto {
            font-size: 10px;
            font-style: italic;
            color: #059669;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            font-weight: 700;
            color: #059669;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
        }

        .schedule-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .schedule-info h3 {
            font-size: 12px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 8px;
        }

        .info-label {
            font-weight: 700;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        thead {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        td {
            padding: 10px 8px;
            font-size: 9px;
            color: #374151;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>

<body>
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
            </div>
        </div>

        <div class="report-title">Enrolled Students List</div>
    </div>

    <div class="schedule-info">
        <h3>SCHEDULE INFORMATION</h3>
        <div class="info-grid">
            <div class="info-label">Course:</div>
            <div>{{ $schedule->course->code }} - {{ $schedule->course->name }}</div>

            <div class="info-label">Section:</div>
            <div>{{ $schedule->section->name }}</div>

            <div class="info-label">Faculty:</div>
            <div>{{ $schedule->faculty->user->name }}</div>

            <div class="info-label">Schedule:</div>
            <div>{{ $schedule->day }} {{ date('g:i A', strtotime($schedule->start_time)) }} -
                {{ date('g:i A', strtotime($schedule->end_time)) }}</div>

            <div class="info-label">Room:</div>
            <div>{{ $schedule->room->code }}</div>

            <div class="info-label">Total Enrolled:</div>
            <div><strong>{{ $schedule->enrollments->count() }}</strong> / {{ $schedule->max_students }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Year Level</th>
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
                    <td>{{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">No students enrolled</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} Aklan Catholic College. All rights reserved.
    </div>
</body>

</html>
