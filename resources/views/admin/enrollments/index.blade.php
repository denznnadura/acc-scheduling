{{-- resources/views/admin/enrollments/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Enrollment Management</x-slot>
    <x-slot name="breadcrumb">Admin / Enrollments</x-slot>

    <style>
        .enrollment-container { max-width: 1400px; margin: 0 auto; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .page-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 16px; }
        .page-actions h1 { font-size: 24px; font-weight: 700; color: var(--text-primary); margin: 0; }
        .enroll-btn { background: var(--acc-primary); border: none; border-radius: 8px; padding: 10px 20px; color: white; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 6px; transition: all 0.2s; text-decoration: none; cursor: pointer; }
        .enroll-btn:hover { background: var(--acc-light-blue); color: white; }
        .filter-card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 2000; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-card { background: var(--bg-secondary); border-radius: 12px; padding: 24px; max-width: 800px; width: 95%; max-height: 90vh; overflow-y: auto; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h2 { font-size: 18px; font-weight: 700; color: var(--text-primary); }
        .close-modal { background: transparent; border: none; font-size: 24px; color: var(--text-tertiary); cursor: pointer; }
        .form-label { font-size: 12px; font-weight: 600; color: var(--text-tertiary); margin-bottom: 6px; display: block; }
        .form-select { border: 1px solid var(--border-color); border-radius: 8px; padding: 10px 12px; font-size: 13px; width: 100%; margin-bottom: 16px; }
        .table-card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
        .enrollments-table { width: 100%; border-collapse: collapse; }
        .enrollments-table thead { background: var(--bg-primary); border-bottom: 1px solid var(--border-color); }
        .enrollments-table thead th { padding: 12px 16px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary); text-align: left; }
        .enrollments-table tbody td { padding: 16px; font-size: 13px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); }
        .enrollments-table tbody tr:hover { background: var(--bg-primary); }
        .view-btn { background: #e0f2fe; color: #0369a1; border: none; border-radius: 6px; padding: 8px 16px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; }
        .view-btn:hover { background: #bae6fd; }
        .drop-btn-sm { background: #fee2e2; color: #991b1b; border: none; border-radius: 4px; padding: 4px 8px; font-size: 11px; cursor: pointer; }
        .info-box { background: #e0f2fe; color: #0369a1; padding: 12px; border-radius: 8px; font-size: 12px; margin-bottom: 16px; border: 1px solid #bae6fd; }
        
        /* Modal Table Styles */
        .modal-table { width: 100%; margin-top: 10px; border: 1px solid var(--border-color); border-radius: 8px; }
        .modal-table th { background: var(--bg-primary); padding: 10px; font-size: 11px; color: var(--text-tertiary); text-align: left; border-bottom: 1px solid var(--border-color); }
        .modal-table td { padding: 10px; font-size: 12px; border-bottom: 1px solid var(--border-light); }
    </style>

    <div class="enrollment-container">
        <div class="page-actions">
            <h1>Enrollment Management</h1>
            <button class="enroll-btn" onclick="openEnrollModal()">
                <i class='bx bx-plus'></i>
                Quick Enroll Student
            </button>
        </div>

        <div class="filter-card">
            <form method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Filter by Section</label>
                        <select name="section_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Sections</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }} ({{ $section->program->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-card">
            <table class="enrollments-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        <tr>
                            <td>
                                <strong>{{ $enrollment->student->user->name }}</strong><br>
                                <small style="color: var(--text-tertiary);">{{ $enrollment->student->student_id }}</small>
                            </td>
                            <td>{{ $enrollment->student->section->name }}</td>
                            <td>
                                <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                    Enrolled
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <button class="view-btn" onclick="viewSchedule({{ $enrollment->student_id }}, '{{ $enrollment->student->user->name }}')">
                                    <i class='bx bx-show'></i> View Schedule
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px;">No enrollments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $enrollments->links() }}
        </div>
    </div>

    {{-- Modal para sa Quick Enroll --}}
    <div class="modal-overlay" id="enrollModal">
        <div class="modal-card" style="max-width: 500px;">
            <div class="modal-header">
                <h2>Quick Section Enrollment</h2>
                <button class="close-modal" onclick="closeEnrollModal()"><i class='bx bx-x'></i></button>
            </div>
            <div class="info-box">
                <i class='bx bx-info-circle'></i>
                Selecting a student will automatically enroll them in <strong>all active schedules</strong> assigned to their section.
            </div>
            <form action="{{ route('admin.enrollments.store') }}" method="POST">
                @csrf
                <label class="form-label">Select Student</label>
                <select name="student_id" class="form-select" required>
                    <option value="">Choose Student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->user->name }} — Section: {{ $student->section->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="enroll-btn" style="width: 100%; justify-content: center;">
                    Confirm & Enroll to Section
                </button>
            </form>
        </div>
    </div>

    {{-- Modal para sa View Schedule --}}
    <div class="modal-overlay" id="viewScheduleModal">
        <div class="modal-card">
            <div class="modal-header">
                <h2 id="modalStudentName">Student Schedule</h2>
                <button class="close-modal" onclick="closeViewModal()"><i class='bx bx-x'></i></button>
            </div>
            <div id="loadingSchedule" style="text-align: center; padding: 20px; display: none;">
                <i class='bx bx-loader-alt bx-spin' style="font-size: 24px; color: var(--acc-primary);"></i>
            </div>
            <div class="table-responsive">
                <table class="modal-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Room</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleTableBody">
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openEnrollModal() {
                document.getElementById('enrollModal').classList.add('active');
            }

            function closeEnrollModal() {
                document.getElementById('enrollModal').classList.remove('active');
            }

            function closeViewModal() {
                document.getElementById('viewScheduleModal').classList.remove('active');
            }

            function viewSchedule(studentId, studentName) {
                document.getElementById('modalStudentName').innerText = "Schedule: " + studentName;
                document.getElementById('scheduleTableBody').innerHTML = "";
                document.getElementById('loadingSchedule').style.display = "block";
                document.getElementById('viewScheduleModal').classList.add('active');

                fetch(`/admin/enrollments/schedule/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loadingSchedule').style.display = "none";
                        let html = '';
                        if (data.length === 0) {
                            html = '<tr><td colspan="5" style="text-align: center;">No schedules found</td></tr>';
                        } else {
                            data.forEach(item => {
                                // Format time
                                let startTime = new Date('1970-01-01T' + item.schedule.start_time).toLocaleTimeString([], {hour: 'numeric', minute:'2-digit', hour12: true});
                                let endTime = new Date('1970-01-01T' + item.schedule.end_time).toLocaleTimeString([], {hour: 'numeric', minute:'2-digit', hour12: true});
                                
                                html += `
                                    <tr>
                                        <td><strong>${item.schedule.course.code}</strong><br><small>${item.schedule.course.name}</small></td>
                                        <td>${item.schedule.day}</td>
                                        <td>${startTime} - ${endTime}</td>
                                        <td>${item.schedule.room ? item.schedule.room.code : 'N/A'}</td>
                                        <td>
                                            <form action="/admin/enrollments/${item.id}" method="POST" onsubmit="return confirm('Drop this subject?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="drop-btn-sm">Drop</button>
                                            </form>
                                        </td>
                                    </tr>
                                `;
                            });
                        }
                        document.getElementById('scheduleTableBody').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('loadingSchedule').style.display = "none";
                        document.getElementById('scheduleTableBody').innerHTML = '<tr><td colspan="5" style="text-align: center; color: red;">Error loading schedule.</td></tr>';
                    });
            }

            window.onclick = function(event) {
                if (event.target.classList.contains('modal-overlay')) {
                    closeEnrollModal();
                    closeViewModal();
                }
            }
        </script>
    @endpush
</x-app-layout>