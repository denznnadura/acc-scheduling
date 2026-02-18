{{-- resources/views/schedules/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Schedules</x-slot>
    <x-slot name="breadcrumb">Manage Schedules</x-slot>

    <style>
        /* Minimalist Schedules Page */
        .schedules-container {
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

        /* Minimalist Filter */
        .filter-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            margin-bottom: 6px;
            display: block;
        }

        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .filter-select:focus {
            border-color: var(--acc-primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            outline: none;
        }

        .filter-btn {
            background: var(--acc-primary);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            color: white;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s;
            width: 100%;
            margin-top: 20px;
        }

        .filter-btn:hover {
            background: var(--acc-light-blue);
        }

        .filter-btn i {
            font-size: 16px;
        }

        /* Minimalist Table */
        .table-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .schedules-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedules-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .schedules-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .schedules-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .schedules-table tbody tr {
            transition: background 0.2s;
        }

        .schedules-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .schedules-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Course Badge */
        .course-badge {
            background: var(--acc-primary);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge.active {
            background: #f0fdf4;
            color: #059669;
        }

        .status-badge.inactive {
            background: #f9fafb;
            color: #6b7280;
        }

        .status-badge i {
            font-size: 12px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
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

        .action-btn.students {
            background: #dbeafe;
            color: #1e40af;
        }

        .action-btn.students:hover {
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

            .filter-card {
                padding: 16px;
            }

            .schedules-table thead th {
                padding: 10px 12px;
                font-size: 10px;
            }

            .schedules-table tbody td {
                padding: 12px;
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="schedules-container">
        <!-- Header -->
        <div class="page-actions">
            <h1>Class Schedules</h1>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('schedules.create') }}" class="create-btn">
                    <i class='bx bx-plus'></i>
                    New Schedule
                </a>
            @endif
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <form method="GET" action="{{ route('schedules.index') }}">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="filter-label">Semester</label>
                        <select name="semester_id" class="form-select filter-select">
                            <option value="">All Semesters</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }} ({{ $semester->academicYear->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="filter-label">Section</label>
                        <select name="section_id" class="form-select filter-select">
                            <option value="">All Sections</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }} - {{ $section->program->code }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="filter-label">Room</label>
                        <select name="room_id" class="form-select filter-select">
                            <option value="">All Rooms</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->code }} - {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3">
                        <button type="submit" class="filter-btn">
                            <i class='bx bx-search'></i>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-wrapper">
                <table class="schedules-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Faculty</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Students</th>
                            <th>Status</th>
                            @if (auth()->user()->isAdmin() || auth()->user()->isFaculty())
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>
                                    <span class="course-badge">{{ $schedule->course->code }}</span>
                                </td>
                                <td><strong>{{ $schedule->section->name }}</strong></td>
                                <td>{{ $schedule->faculty->user->name }}</td>
                                <td>{{ $schedule->room->code }}</td>
                                <td>{{ $schedule->day }}</td>
                                <td>
                                    {{ date('g:i A', strtotime($schedule->start_time)) }} -
                                    {{ date('g:i A', strtotime($schedule->end_time)) }}
                                </td>
                                <td>
                                    <strong>{{ $schedule->enrollments->count() }}</strong>/{{ $schedule->max_students }}
                                </td>


                                <td>
                                    <span
                                        class="status-badge {{ $schedule->status === 'active' ? 'active' : 'inactive' }}">
                                        <i
                                            class='bx bx-{{ $schedule->status === 'active' ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </td>
                                @if (auth()->user()->isAdmin() || auth()->user()->isFaculty())
                                    <td>
                                        <div class="action-buttons">
                                            <!-- View Students Button -->
                                            <a href="{{ route('schedules.students', $schedule) }}"
                                                class="action-btn students">
                                                <i class='bx bx-user'></i>
                                                Students
                                            </a>

                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('schedules.edit', $schedule) }}"
                                                    class="action-btn edit">
                                                    <i class='bx bx-edit'></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('schedules.destroy', $schedule) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete"
                                                        onclick="return confirm('Are you sure you want to delete this schedule?')">
                                                        <i class='bx bx-trash'></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="{{ auth()->user()->isAdmin() || auth()->user()->isFaculty() ? '9' : '8' }}">
                                    <div class="empty-state">
                                        <i class='bx bx-calendar-x'></i>
                                        <div class="empty-state-title">No Schedules Found</div>
                                        <div class="empty-state-text">Try adjusting filters or create a new schedule
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($schedules->hasPages())
                <div class="pagination-wrapper">
                    {{ $schedules->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
