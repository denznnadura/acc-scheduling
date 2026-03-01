<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Room Utilization Report - Aklan Catholic College</title>
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

        /* Layout Fix: Inalis ang Flexbox, pinalitan ng Table para sa Header */
        .header-table {
            width: 100%;
            border: none;
            margin-bottom: 15px;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
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
            font-weight: bold;
            color: #1e40af;
            margin: 0;
        }

        .header .motto {
            font-size: 10px;
            font-style: italic;
            color: #059669;
            font-weight: bold;
        }

        .header .address {
            font-size: 9px;
            color: #6b7280;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #059669;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
            text-align: center;
        }

        .header-info {
            font-size: 11px;
            color: #6b7280;
            background: #f9fafb;
            padding: 10px;
            border-radius: 8px;
            display: block;
            margin: 10px auto;
            width: fit-content;
            text-align: center;
        }

        .header-info strong {
            color: #1f2937;
        }

        /* Main Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .data-table thead {
            background-color: #1e40af;
        }

        .data-table th {
            padding: 10px 8px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            border: 1px solid #1e40af;
        }

        .data-table td {
            padding: 8px;
            font-size: 9px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }

        .room-code {
            font-weight: bold;
            color: #1e40af;
        }

        .type-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 8px;
            background: #dbeafe;
            color: #1e40af;
        }

        /* Utilization Bar Fix */
        .utilization-bar {
            width: 100%;
            height: 14px;
            background: #f3f4f6;
            border-radius: 7px;
            position: relative;
        }

        .utilization-fill {
            height: 14px;
            border-radius: 7px;
            text-align: center;
            font-size: 8px;
            color: white;
            font-weight: bold;
            line-height: 14px;
        }

        .low { background-color: #059669; }
        .medium { background-color: #f59e0b; }
        .high { background-color: #dc2626; }

        /* Summary Grid Fix: Pinalitan ng Table */
        .summary-table {
            width: 100%;
            margin-top: 25px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
        }

        .summary-table td {
            padding: 15px;
            border: none;
        }

        .summary-label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #1e40af;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            padding-top: 10px;
        }

        .footer-contact { font-size: 8px; color: #6b7280; }
        .footer-copyright { font-size: 8px; color: #9ca3af; }
    </style>
</head>

<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 70px;">
                    @php
                        $logoPath = public_path('assets/logo.png');
                        $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
                    @endphp
                    @if ($logoData)
                        <img src="data:image/png;base64,{{ $logoData }}" class="school-logo">
                    @endif
                </td>
                <td class="school-info">
                    <h1>Aklan Catholic College</h1>
                    <div class="motto">Pro Deo Et Patria</div>
                    <div class="address">
                        Kalibo, Aklan, Philippines<br>
                        Tel: (036) 268-5137 | Email: acc@aklan.edu.ph
                    </div>
                </td>
            </tr>
        </table>

        <div class="report-title">Room Utilization Report</div>

        <div class="header-info">
            <strong>Semester:</strong> {{ $semester->name }} | 
            <strong>Academic Year:</strong> {{ $semester->academicYear->code }} | 
            <strong>Generated:</strong> {{ now()->format('F d, Y g:i A') }}
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">Code</th>
                <th style="width: 20%;">Room Name</th>
                <th style="width: 15%;">Building</th>
                <th style="width: 12%;">Type</th>
                <th style="width: 8%;">Capacity</th>
                <th style="width: 10%;">Schedules</th>
                <th style="width: 25%;">Utilization</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                @php
                    $maxSlots = 50; 
                    $utilization = $maxSlots > 0 ? round(($room->schedules_count / $maxSlots) * 100) : 0;
                    $barClass = ($utilization >= 80) ? 'high' : (($utilization >= 50) ? 'medium' : 'low');
                @endphp
                <tr>
                    <td class="room-code">{{ $room->code }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->building }}</td>
                    <td><span class="type-badge">{{ ucwords(str_replace('_', ' ', $room->type)) }}</span></td>
                    <td style="text-align: center;">{{ $room->capacity }}</td>
                    <td style="text-align: center;">{{ $room->schedules_count }}</td>
                    <td>
                        <div class="utilization-bar">
                            <div class="utilization-fill {{ $barClass }}" style="width: {{ $utilization }}%;">
                                {{ $utilization }}%
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No room data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @php
        $totalRooms = $rooms->count();
        $totalCapacity = $rooms->sum('capacity');
        $totalSchedules = $rooms->sum('schedules_count');
        $avgUtilization = $totalRooms > 0 ? round($rooms->avg(function($r){ return (50 > 0) ? ($r->schedules_count / 50) * 100 : 0; })) : 0;
    @endphp

    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Total Rooms</div>
                <div class="summary-value">{{ $totalRooms }}</div>
            </td>
            <td>
                <div class="summary-label">Total Capacity</div>
                <div class="summary-value">{{ $totalCapacity }}</div>
            </td>
            <td>
                <div class="summary-label">Total Schedules</div>
                <div class="summary-value">{{ $totalSchedules }}</div>
            </td>
            <td>
                <div class="summary-label">Avg Utilization</div>
                <div class="summary-value">{{ $avgUtilization }}%</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <div class="footer-contact">Aklan Catholic College | Kalibo, Aklan | www.aklancatholiccollege.edu.ph</div>
        <div class="footer-copyright">© {{ date('Y') }} ACC | System-Generated Report</div>
    </div>
</body>
</html>