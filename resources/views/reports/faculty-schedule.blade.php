{{-- resources/views/reports/faculty-schedule.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; padding: 10px; color: #1f2937; }
        .header { text-align: center; margin-bottom: 20px; }
        .school-logo { width: 70px; height: 70px; }
        .school-name { font-size: 18px; font-weight: bold; color: #1e40af; margin: 5px 0; }
        .motto { font-style: italic; color: #059669; font-weight: bold; margin: 0; }
        .report-title { font-size: 14px; font-weight: bold; margin-top: 15px; text-transform: uppercase; }
        
        .semester-info { font-size: 12px; margin-top: 5px; font-weight: bold; }

        .info-section { margin: 20px 0; font-size: 12px; }
        .info-label { font-weight: bold; }
        .info-value { border-bottom: 1px solid #000; padding-right: 50px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f3f4f6; border: 1px solid #000; padding: 10px; text-align: center; text-transform: uppercase; }
        td { border: 1px solid #000; padding: 8px; text-align: center; }

        .signature-section { margin-top: 50px; width: 100%; }
        .sig-table { width: 100%; border: none !important; margin-top: 20px; }
        .sig-table td { border: none !important; width: 50%; text-align: center; vertical-align: bottom; }
        .sig-container { width: 80%; margin: 0 auto; }
        .sig-line { border-top: 1px solid #000; font-weight: bold; padding-top: 5px; text-transform: uppercase; }
        
        .footer { margin-top: 40px; text-align: center; font-size: 9px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/logo.png') }}" class="school-logo">
        <div class="school-name">AKLAN CATHOLIC COLLEGE</div>
        <p class="motto">Pro Deo Et Patria</p>
        <div class="report-title">FACULTY CLASS SCHEDULE</div>
        
        @if($schedules->count() > 0 && $schedules->first()->semester)
            <div class="semester-info">
                {{ $schedules->first()->semester->name }} | 
                Academic Year: {{ $schedules->first()->semester->academicYear->code ?? '' }}
            </div>
        @endif
    </div>

    <div class="info-section">
        <span class="info-label">Name:</span> 
        <span class="info-value">{{ $name }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th>Day</th>
                <th>Time</th>
                <th>Course</th>
                <th>Section</th>
                <th>Room</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $sched)
            <tr>
                <td>{{ $sched->day }}</td>
                <td>
                    {{ date('h:i A', strtotime($sched->start_time)) }} - 
                    {{ date('h:i A', strtotime($sched->end_time)) }}
                </td>
                <td>{{ $sched->course->code ?? '' }}</td>
                <td>{{ $sched->section->name ?? '' }}</td>
                <td>{{ $sched->room->code ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-section">
        <table class="sig-table">
            <tr>
                <td>
                    <div class="sig-container">
                        <p style="text-align: left; margin-bottom: 40px;">Prepared by:</p>
                        <div class="sig-line">{{ $name }}</div>
                        <div style="font-size: 10px;">Faculty Member</div>
                    </div>
                </td>
                <td>
                    <div class="sig-container">
                        <p style="text-align: left; margin-bottom: 40px;">Approved by:</p>
                        <div class="sig-line">DR. NAME OF DEAN</div>
                        <div style="font-size: 10px;">College Dean</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Aklan Catholic College | Kalibo, Aklan | Generated: {{ now()->format('F d, Y g:i A') }}
    </div>
</body>
</html>