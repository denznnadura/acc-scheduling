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
            position: relative;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-actions h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin: 0;
        }

        /* --- DOWNLOAD BUTTONS STYLE --- */
        .download-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-download {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white !important;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-pdf { background-color: #e11d48; }   /* Solid Red */
        .btn-excel { background-color: #10b981; } /* Solid Green */
        .btn-word { background-color: #2563eb; }  /* Solid Blue */

        .btn-download:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* --- CREATE BUTTON --- */
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

        .create-btn:hover { background: var(--acc-light-blue); color: white; }

        /* --- FILTER SECTION --- */
        .filter-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            position: relative;
            z-index: 10;
        }

        .filter-grid-layout {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
        }

        .filter-column {
            flex: 1;
            min-width: 300px;
        }

        .filter-group { margin-bottom: 15px; }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            margin-bottom: 8px;
            display: block;
        }

        .filter-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--text-primary);
            width: 100%;
            background-color: white;
        }

        .filter-btn {
            background: var(--acc-primary);
            border: none;
            border-radius: 8px;
            padding: 12px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            cursor: pointer;
        }

        /* --- TABLE STYLES --- */
        .table-card { 
            background: var(--bg-secondary); 
            border: 1px solid var(--border-color); 
            border-radius: 12px; 
            overflow: hidden;
            position: relative;
            z-index: 5;
        }

        .table-wrapper { overflow-x: auto; }
        .schedules-table { width: 100%; border-collapse: collapse; }
        .schedules-table thead { background: var(--bg-primary); border-bottom: 1px solid var(--border-color); }
        .schedules-table thead th { padding: 14px 16px; font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-tertiary); text-align: left; }
        .schedules-table tbody td { padding: 16px; font-size: 13px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); }
        
        /* Badges */
        .course-badge { background: var(--acc-primary); color: white; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 12px; }
        .status-badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .status-badge.active { background: #f0fdf4; color: #059669; }
        .status-badge.inactive { background: #f9fafb; color: #6b7280; }

        /* Action Buttons Row */
        .action-buttons { 
            display: flex; 
            gap: 8px; 
            align-items: center;
            pointer-events: auto !important;
        }

        .action-btn { 
            padding: 6px 14px; 
            border-radius: 6px; 
            font-size: 12px; 
            font-weight: 600; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
            border: none; 
            transition: all 0.2s;
            cursor: pointer !important;
        }

        .action-btn.students { background: #dbeafe; color: #1e40af; }
        .action-btn.edit { background: #fef3c7; color: #92400e; }
        .action-btn.delete { background: #fee2e2; color: #991b1b; }
        
        .action-btn:hover { transform: translateY(-1px); filter: brightness(0.95); }

    </style>

    <div class="schedules-container">
        <div class="page-actions">
            <h1>Class Schedules</h1>
            
            <div class="d-flex align-items-center gap-3">
                {{-- DITO BINAGO: Faculty lang ang makakakita ng download buttons --}}
                @if (auth()->user()->isFaculty())
                    <div class="download-group">
                        <a href="{{ route('full.pdf') }}" class="btn-download btn-pdf">
                            <i class='bx bxs-file-pdf'></i> PDF
                        </a>
                        <a href="{{ route('full.excel') }}" class="btn-download btn-excel">
                            <i class='bx bxs-file-export'></i> Excel
                        </a>
                        <a href="{{ route('full.word') }}" class="btn-download btn-word">
                            <i class='bx bxs-file-doc'></i> Word
                        </a>
                    </div>
                @endif

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('schedules.create') }}" class="create-btn">
                        <i class='bx bx-plus'></i> New Schedule
                    </a>
                @endif
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('schedules.index') }}">
                <div class="filter-grid-layout">
                    <div class="filter-column">
                        <div class="filter-group">
                            <label class="filter-label">Semester</label>
                            <select name="semester_id" class="form-select filter-select">
                                <option value="">All Semesters</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }} ({{ $semester->academicYear->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Section</label>
                            <select name="section_id" class="form-select filter-select">
                                <option value="">All Sections</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }} - {{ $section->program->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-column">
                        <div class="filter-group">
                            <label class="filter-label">Faculty</label>
                            <select name="faculty_id" class="form-select filter-select">
                                <option value="">All Faculty</option>
                                @foreach ($faculty as $f)
                                    <option value="{{ $f->id }}" {{ request('faculty_id') == $f->id ? 'selected' : '' }}>
                                        {{ $f->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Room</label>
                            <select name="room_id" class="form-select filter-select">
                                <option value="">All Rooms</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->code }} - {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="button-row">
                    <button type="submit" class="filter-btn">
                        <i class='bx bx-search'></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>

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
                                <td><span class="course-badge">{{ $schedule->course->code }}</span></td>
                                <td><strong>{{ $schedule->section->name }}</strong></td>
                                <td>{{ $schedule->faculty->user->name }}</td>
                                <td>{{ $schedule->room->code }}</td>
                                <td>{{ $schedule->day }}</td>
                                <td>
                                    {{ date('g:i A', strtotime($schedule->start_time)) }} -
                                    {{ date('g:i A', strtotime($schedule->end_time)) }}
                                </td>
                                <td><strong>{{ $schedule->enrollments->count() }}</strong>/{{ $schedule->max_students }}</td>
                                <td>
                                    <span class="status-badge {{ $schedule->status === 'active' ? 'active' : 'inactive' }}">
                                        <i class='bx bx-{{ $schedule->status === 'active' ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </td>
                                @if (auth()->user()->isAdmin() || auth()->user()->isFaculty())
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('schedules.students', $schedule->id) }}" class="action-btn students">
                                                <i class='bx bx-user'></i> Students
                                            </a>

                                            @if (auth()->user()->isAdmin())
                                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="action-btn edit">
                                                    <i class='bx bx-edit'></i> Edit
                                                </a>
                                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display: inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="action-btn delete" onclick="return confirm('Delete schedule?')">
                                                        <i class='bx bx-trash'></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class='bx bx-calendar-x' style="font-size: 48px; opacity: 0.3;"></i>
                                        <div class="empty-state-title">No Schedules Found</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($schedules->hasPages())
                <div class="pagination-wrapper" style="padding: 20px;">
                    {{ $schedules->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>