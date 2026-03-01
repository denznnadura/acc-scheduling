{{-- resources/views/semesters/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Semesters</x-slot>
    <x-slot name="breadcrumb">Manage Semesters</x-slot>

    <style>
        /* Minimalist Semesters Page */
        .semesters-container {
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeIn 0.4s ease;
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

        .create-btn i { font-size: 18px; }

        /* Table Card */
        .table-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-wrapper { overflow-x: auto; }

        .semesters-table {
            width: 100%;
            border-collapse: collapse;
        }

        .semesters-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .semesters-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .semesters-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .semesters-table tbody tr:hover { background: var(--bg-primary); }
        .semesters-table tbody tr:last-child td { border-bottom: none; }

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

        .badge.active {
            background: #f0fdf4;
            color: #059669;
        }

        /* Buttons */
        .activate-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid var(--acc-primary);
            background: transparent;
            color: var(--acc-primary);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .activate-btn:hover {
            background: var(--acc-primary);
            color: white;
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
        }

        .action-btn.edit {
            background: #fef3c7;
            color: #92400e;
        }

        .action-btn.edit:hover { background: #fde68a; }

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

        /* Pagination */
        .pagination-wrapper {
            padding: 16px;
            border-top: 1px solid var(--border-light);
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .page-actions { flex-direction: column; align-items: stretch; }
            .action-buttons { flex-direction: column; }
            .action-btn, .activate-btn { width: 100%; justify-content: center; }
        }
    </style>

    <div class="semesters-container">
        <div class="page-actions">
            <h1>Semesters</h1>
            <a href="{{ route('semesters.create') }}" class="create-btn">
                <i class='bx bx-plus'></i>
                Create Semester
            </a>
        </div>

        <div class="table-card">
            <div class="table-wrapper">
                <table class="semesters-table">
                    <thead>
                        <tr>
                            <th>Academic Year</th>
                            <th>Semester</th>
                            <th>Period</th>
                            <th>Enrollment Period</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semesters as $semester)
                            <tr>
                                <td><strong>{{ $semester->academicYear->code }}</strong></td>
                                <td>{{ $semester->name }}</td>
                                <td>
                                    {{ $semester->start_date->format('M d, Y') }} -
                                    {{ $semester->end_date->format('M d, Y') }}
                                </td>
                                <td>
                                    {{ $semester->enrollment_start->format('M d, Y') }} -
                                    {{ $semester->enrollment_end->format('M d, Y') }}
                                </td>
                                <td>
                                    @if ($semester->is_active)
                                        <span class="badge active">
                                            <i class='bx bx-check-circle'></i>
                                            Active
                                        </span>
                                    @else
                                        <form action="{{ route('semesters.activate', $semester) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="activate-btn">
                                                <i class='bx bx-check'></i>
                                                Activate
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('semesters.edit', $semester) }}" class="action-btn edit">
                                            <i class='bx bx-edit'></i>
                                            Edit
                                        </a>
                                        {{-- Delete Form and Button Removed --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class='bx bx-time'></i>
                                        <div class="empty-state-title">No Semesters Found</div>
                                        <div class="empty-state-text">Create a new semester to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($semesters->hasPages())
                <div class="pagination-wrapper">
                    {{ $semesters->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>