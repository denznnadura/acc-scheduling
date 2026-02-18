{{-- resources/views/reports/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Reports</x-slot>
    <x-slot name="breadcrumb">Analytics & Reports</x-slot>

    <style>
        /* Minimalist Reports Page */
        .reports-container {
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
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        /* Report Cards */
        .report-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            transition: all 0.2s;
        }

        .report-card:hover {
            border-color: var(--acc-primary);
            box-shadow: var(--shadow-sm);
        }

        .report-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .report-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .report-icon.primary {
            background: #dbeafe;
            color: #1e40af;
        }

        .report-icon.success {
            background: #d1fae5;
            color: #065f46;
        }

        .report-icon.info {
            background: #cffafe;
            color: #0e7490;
        }

        .report-icon i {
            font-size: 28px;
        }

        .report-info h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .report-info p {
            font-size: 12px;
            color: var(--text-tertiary);
            margin: 0;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            margin-bottom: 6px;
            display: block;
        }

        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            color: var(--text-primary);
            transition: all 0.2s;
            width: 100%;
            margin-bottom: 12px;
        }

        .form-select:focus {
            border-color: var(--acc-primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            outline: none;
        }

        .report-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .report-btn.primary {
            background: var(--acc-primary);
            color: white;
        }

        .report-btn.primary:hover {
            background: var(--acc-light-blue);
        }

        .report-btn.success {
            background: #059669;
            color: white;
        }

        .report-btn.success:hover {
            background: #047857;
        }

        .report-btn.info {
            background: #0891b2;
            color: white;
        }

        .report-btn.info:hover {
            background: #0e7490;
        }

        .report-btn.excel {
            background: #10b981;
            color: white;
        }

        .report-btn.excel:hover {
            background: #059669;
        }

        .report-btn.word {
            background: #2563eb;
            color: white;
        }

        .report-btn.word:hover {
            background: #1d4ed8;
        }

        .report-btn i {
            font-size: 14px;
        }

        /* Stats Card */
        .stats-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 24px;
        }

        .stats-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-light);
        }

        .stats-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .stats-body {
            padding: 20px;
        }

        .stat-item {
            background: var(--bg-primary);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: all 0.2s;
        }

        .stat-item:hover {
            background: #eff6ff;
        }

        .stat-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .stat-icon.primary {
            color: #1e40af;
        }

        .stat-icon.success {
            color: #059669;
        }

        .stat-icon.info {
            color: #0891b2;
        }

        .stat-icon.warning {
            color: #d97706;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-tertiary);
            margin: 0;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 20px;
            }

            .report-header {
                flex-direction: column;
                text-align: center;
            }

            .stat-item {
                margin-bottom: 12px;
            }
        }
    </style>

    <div class="reports-container">
        <!-- Header -->
        <div class="page-header">
            <h1>Reports & Analytics</h1>
        </div>

        <!-- Report Cards -->
        <div class="row g-3 mb-4">
            <!-- Schedule Report -->
            <div class="col-12 col-md-4">
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon primary">
                            <i class='bx bxs-calendar'></i>
                        </div>
                        <div class="report-info">
                            <h3>Schedule Report</h3>
                            <p>Complete schedule report</p>
                        </div>
                    </div>
                    <div>
                        <label for="semester_schedule" class="form-label">Select Semester</label>
                        <select name="semester_id" id="semester_schedule" class="form-select" required>
                            <option value="">Choose Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}">
                                    {{ $semester->name }} ({{ $semester->academicYear->code }})
                                </option>
                            @endforeach
                        </select>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                            <button type="button" class="report-btn info" onclick="viewSchedule()">
                                <i class='bx bx-show'></i>
                                View
                            </button>
                            <button type="button" class="report-btn primary" onclick="downloadSchedulePdf()">
                                <i class='bx bxs-file-pdf'></i>
                                PDF
                            </button>
                            <button type="button" class="report-btn excel" onclick="downloadScheduleExcel()">
                                <i class='bx bxs-file'></i>
                                Excel
                            </button>
                            <button type="button" class="report-btn word" onclick="downloadScheduleWord()">
                                <i class='bx bxs-file-doc'></i>
                                Word
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faculty Load Report -->
            <div class="col-12 col-md-4">
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon success">
                            <i class='bx bxs-user-badge'></i>
                        </div>
                        <div class="report-info">
                            <h3>Faculty Load Report</h3>
                            <p>Faculty teaching loads</p>
                        </div>
                    </div>
                    <div>
                        <label for="semester_faculty" class="form-label">Select Semester</label>
                        <select name="semester_id" id="semester_faculty" class="form-select" required>
                            <option value="">Choose Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}">
                                    {{ $semester->name }} ({{ $semester->academicYear->code }})
                                </option>
                            @endforeach
                        </select>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                            <button type="button" class="report-btn info" onclick="viewFaculty()">
                                <i class='bx bx-show'></i>
                                View
                            </button>
                            <button type="button" class="report-btn primary" onclick="downloadFacultyPdf()">
                                <i class='bx bxs-file-pdf'></i>
                                PDF
                            </button>
                            <button type="button" class="report-btn excel" onclick="downloadFacultyExcel()">
                                <i class='bx bxs-file'></i>
                                Excel
                            </button>
                            <button type="button" class="report-btn word" onclick="downloadFacultyWord()">
                                <i class='bx bxs-file-doc'></i>
                                Word
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Utilization Report -->
            <div class="col-12 col-md-4">
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-icon info">
                            <i class='bx bxs-door-open'></i>
                        </div>
                        <div class="report-info">
                            <h3>Room Utilization</h3>
                            <p>Room usage statistics</p>
                        </div>
                    </div>
                    <div>
                        <label for="semester_room" class="form-label">Select Semester</label>
                        <select name="semester_id" id="semester_room" class="form-select" required>
                            <option value="">Choose Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}">
                                    {{ $semester->name }} ({{ $semester->academicYear->code }})
                                </option>
                            @endforeach
                        </select>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
                            <button type="button" class="report-btn info" onclick="viewRoom()">
                                <i class='bx bx-show'></i>
                                View
                            </button>
                            <button type="button" class="report-btn primary" onclick="downloadRoomPdf()">
                                <i class='bx bxs-file-pdf'></i>
                                PDF
                            </button>
                            <button type="button" class="report-btn excel" onclick="downloadRoomExcel()">
                                <i class='bx bxs-file'></i>
                                Excel
                            </button>
                            <button type="button" class="report-btn word" onclick="downloadRoomWord()">
                                <i class='bx bxs-file-doc'></i>
                                Word
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="stats-card">
            <div class="stats-header">
                <h2>Quick Statistics</h2>
            </div>
            <div class="stats-body">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <i class='bx bxs-calendar stat-icon primary'></i>
                            <div class="stat-value">{{ \App\Models\Schedule::count() }}</div>
                            <p class="stat-label">Total Schedules</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <i class='bx bxs-user-badge stat-icon success'></i>
                            <div class="stat-value">{{ \App\Models\Faculty::count() }}</div>
                            <p class="stat-label">Faculty Members</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <i class='bx bxs-user stat-icon info'></i>
                            <div class="stat-value">{{ \App\Models\Student::count() }}</div>
                            <p class="stat-label">Students</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <i class='bx bxs-door-open stat-icon warning'></i>
                            <div class="stat-value">{{ \App\Models\Room::count() }}</div>
                            <p class="stat-label">Rooms</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function checkSemester(selectId) {
                const semesterId = document.getElementById(selectId).value;
                if (!semesterId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Semester Selected',
                        text: 'Please select a semester first',
                        confirmButtonColor: '#1e40af'
                    });
                    return null;
                }
                return semesterId;
            }

            // Schedule Reports
            function viewSchedule() {
                const semesterId = checkSemester('semester_schedule');
                if (semesterId) {
                    window.location.href = '{{ route('reports.schedule-view') }}?semester_id=' + semesterId;
                }
            }

            function downloadSchedulePdf() {
                const semesterId = checkSemester('semester_schedule');
                if (semesterId) {
                    window.open('{{ route('reports.schedule-pdf') }}?semester_id=' + semesterId, '_blank');
                }
            }

            function downloadScheduleExcel() {
                const semesterId = checkSemester('semester_schedule');
                if (semesterId) {
                    window.open('{{ route('reports.schedule-excel') }}?semester_id=' + semesterId, '_blank');
                }
            }

            function downloadScheduleWord() {
                const semesterId = checkSemester('semester_schedule');
                if (semesterId) {
                    window.open('{{ route('reports.schedule-word') }}?semester_id=' + semesterId, '_blank');
                }
            }

            // Faculty Load Reports
            function viewFaculty() {
                const semesterId = checkSemester('semester_faculty');
                if (semesterId) {
                    window.location.href = '{{ route('reports.faculty-load') }}?semester_id=' + semesterId;
                }
            }

            function downloadFacultyPdf() {
                const semesterId = checkSemester('semester_faculty');
                if (semesterId) {
                    window.open('{{ route('reports.faculty-load-pdf') }}?semester_id=' + semesterId, '_blank');
                }
            }

            function downloadFacultyExcel() {
                const semesterId = checkSemester('semester_faculty');
                if (semesterId) {
                    window.open('{{ route('reports.faculty-load-excel') }}?semester_id=' + semesterId, '_blank');
                }
            }

            function downloadFacultyWord() {
                const semesterId = checkSemester('semester_faculty');
                if (semesterId) {
                    window.open('{{ route('reports.faculty-load-word') }}?semester_id=' + semesterId, '_blank');
                }
            }

            // Room Utilization Reports
            function viewRoom() {
                const semesterId = checkSemester('semester_room');
                if (semesterId) {
                    window.location.href = '{{ route('reports.room-utilization') }}?semester_id=' + semesterId;
                }
            }

            function downloadRoomPdf() {
                const semesterId = checkSemester('semester_room');
                if (semesterId) {
                    window.open('{{ route('reports.room-utilization-pdf') }}?semester_id=' + semesterId, '_blank');
                }
            }

            function downloadRoomExcel() {
                const semesterId = checkSemester('semester_room');
                if (semesterId) {
                    window.open('{{ route('reports.room-utilization-excel') }}?semester_id=' + semesterId, '_blank');
                }
            }

            function downloadRoomWord() {
                const semesterId = checkSemester('semester_room');
                if (semesterId) {
                    window.open('{{ route('reports.room-utilization-word') }}?semester_id=' + semesterId, '_blank');
                }
            }
        </script>
    @endpush
</x-app-layout>
