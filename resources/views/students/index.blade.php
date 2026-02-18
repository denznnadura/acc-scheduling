{{-- resources/views/students/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Students</x-slot>
    <x-slot name="breadcrumb">Manage Students</x-slot>

    <style>
        /* Minimalist Students Page */
        .students-container {
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

        .page-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
        }

        .page-actions h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin: 0;
        }

        .create-btn {
            background: var(--acc-primary);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: white;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .create-btn:hover {
            background: var(--acc-light-blue);
            color: white;
        }

        .create-btn i {
            font-size: 18px;
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

        .students-table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .students-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .students-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .students-table tbody tr {
            transition: background 0.2s;
        }

        .students-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .students-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge.regular {
            background: #f0fdf4;
            color: #059669;
        }

        .badge.irregular {
            background: #fef3c7;
            color: #92400e;
        }

        .badge.loa {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge.probation {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge.active {
            background: #f0fdf4;
            color: #059669;
        }

        .badge.inactive {
            background: #f9fafb;
            color: #6b7280;
        }

        .badge i {
            font-size: 12px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .action-btn.schedule {
            background: #dbeafe;
            color: #1e40af;
        }

        .action-btn.schedule:hover {
            background: #bfdbfe;
        }

        .action-btn.edit {
            background: #fef3c7;
            color: #92400e;
        }

        .action-btn.edit:hover {
            background: #fde68a;
        }

        .action-btn.delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-btn.delete:hover {
            background: #fecaca;
        }

        .action-btn i {
            font-size: 14px;
        }

        /* Fixed Dropdown Menu - Portal Style */
        .schedule-dropdown {
            display: none;
            position: fixed;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 99999;
            min-width: 150px;
            animation: slideDown 0.2s ease;
        }

        .schedule-dropdown.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .schedule-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border-bottom: 1px solid #f3f4f6;
        }

        .schedule-dropdown a:first-child {
            border-radius: 8px 8px 0 0;
        }

        .schedule-dropdown a:last-child {
            border-bottom: none;
            border-radius: 0 0 8px 8px;
        }

        .schedule-dropdown a:hover {
            background: #f9fafb;
            color: #1e40af;
        }

        .schedule-dropdown a i {
            font-size: 18px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
        }

        .empty-state i {
            font-size: 48px;
            color: var(--text-tertiary);
            opacity: 0.3;
            margin-bottom: 16px;
        }

        .empty-state-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .empty-state-text {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        /* Pagination */
        .pagination-wrapper {
            padding: 16px;
            border-top: 1px solid var(--border-light);
            display: flex;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .page-actions h1 {
                font-size: 20px;
            }

            .create-btn {
                justify-content: center;
            }

            .students-table thead th {
                padding: 10px 12px;
                font-size: 10px;
            }

            .students-table tbody td {
                padding: 12px;
                font-size: 12px;
            }

            .action-buttons {
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="students-container">
        <!-- Header -->
        <div class="page-actions">
            <h1>Students</h1>
            <a href="{{ route('students.create') }}" class="create-btn">
                <i class='bx bx-plus'></i>
                Add Student
            </a>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-wrapper">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Program</th>
                            <th>Year Level</th>
                            <th>Status</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td><strong>{{ $student->student_id }}</strong></td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->program->code }}</td>
                                <td>{{ $student->year_level }}</td>
                                <td>
                                    <span class="badge {{ $student->status }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $student->is_active ? 'active' : 'inactive' }}">
                                        <i class='bx bx-{{ $student->is_active ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ $student->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Schedule Button -->
                                        <button type="button" class="action-btn schedule"
                                            id="schedule-btn-{{ $student->id }}"
                                            onclick="toggleScheduleMenu(event, {{ $student->id }})">
                                            <i class='bx bx-calendar'></i>
                                            Schedule
                                        </button>

                                        <a href="{{ route('students.edit', $student) }}" class="action-btn edit">
                                            <i class='bx bx-edit'></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete"
                                                onclick="return confirm('Are you sure you want to delete this student?')">
                                                <i class='bx bx-trash'></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class='bx bx-user'></i>
                                        <div class="empty-state-title">No Students Found</div>
                                        <div class="empty-state-text">Add a student to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($students->hasPages())
                <div class="pagination-wrapper">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Fixed Dropdown Menu (Portal) -->
    <div id="schedule-dropdown" class="schedule-dropdown">
        <a href="#" id="pdf-link" target="_blank">
            <i class='bx bxs-file-pdf' style="color: #dc2626;"></i>
            Download PDF
        </a>
        <a href="#" id="excel-link" target="_blank">
            <i class='bx bxs-file' style="color: #059669;"></i>
            Download Excel
        </a>
        <a href="#" id="word-link" target="_blank">
            <i class='bx bxs-file-doc' style="color: #2563eb;"></i>
            Download Word
        </a>
    </div>

    @push('scripts')
        <script>
            const dropdown = document.getElementById('schedule-dropdown');
            let currentStudentId = null;

            function toggleScheduleMenu(event, studentId) {
                event.stopPropagation();

                const button = document.getElementById(`schedule-btn-${studentId}`);
                const buttonRect = button.getBoundingClientRect();

                // Close if clicking same button
                if (currentStudentId === studentId && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                    currentStudentId = null;
                    return;
                }

                // Update links with student routes
                document.getElementById('pdf-link').href = `/students/${studentId}/schedule-pdf`;
                document.getElementById('excel-link').href = `/students/${studentId}/schedule-excel`;
                document.getElementById('word-link').href = `/students/${studentId}/schedule-word`;

                // Position dropdown below button
                dropdown.style.top = (buttonRect.bottom + window.scrollY + 4) + 'px';
                dropdown.style.left = buttonRect.left + 'px';

                // Show dropdown
                dropdown.classList.add('show');
                currentStudentId = studentId;
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.action-btn.schedule') && !e.target.closest('#schedule-dropdown')) {
                    dropdown.classList.remove('show');
                    currentStudentId = null;
                }
            });

            // Update dropdown position on scroll
            window.addEventListener('scroll', function() {
                if (dropdown.classList.contains('show') && currentStudentId) {
                    const button = document.getElementById(`schedule-btn-${currentStudentId}`);
                    if (button) {
                        const buttonRect = button.getBoundingClientRect();
                        dropdown.style.top = (buttonRect.bottom + window.scrollY + 4) + 'px';
                        dropdown.style.left = buttonRect.left + 'px';
                    }
                }
            });

            // Close dropdown on link click
            document.querySelectorAll('#schedule-dropdown a').forEach(link => {
                link.addEventListener('click', function() {
                    dropdown.classList.remove('show');
                    currentStudentId = null;
                });
            });
        </script>
    @endpush
</x-app-layout>
