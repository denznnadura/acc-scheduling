{{-- resources/views/programs/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Programs</x-slot>
    <x-slot name="breadcrumb">Manage Programs</x-slot>

    <style>
        /* Minimalist Programs Page */
        .programs-container {
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

        .programs-table {
            width: 100%;
            border-collapse: collapse;
        }

        .programs-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .programs-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .programs-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .programs-table tbody tr {
            transition: background 0.2s;
        }

        .programs-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .programs-table tbody tr:last-child td {
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

        .badge.type {
            background: #dbeafe;
            color: #1e40af;
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

            .programs-table thead th {
                padding: 10px 12px;
                font-size: 10px;
            }

            .programs-table tbody td {
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

    <div class="programs-container">
        <!-- Header -->
        <div class="page-actions">
            <h1>Programs</h1>
            <a href="{{ route('programs.create') }}" class="create-btn">
                <i class='bx bx-plus'></i>
                Create Program
            </a>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-wrapper">
                <table class="programs-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                            <tr>
                                <td><strong>{{ $program->code }}</strong></td>
                                <td>{{ $program->name }}</td>
                                <td>{{ $program->department->name }}</td>
                                <td>
                                    <span class="badge type">
                                        {{ ucfirst($program->type) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($program->duration_years)
                                        {{ $program->duration_years }} years
                                    @elseif($program->duration_months)
                                        {{ $program->duration_months }} months
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $program->is_active ? 'active' : 'inactive' }}">
                                        <i class='bx bx-{{ $program->is_active ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ $program->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('programs.edit', $program) }}" class="action-btn edit">
                                            <i class='bx bx-edit'></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('programs.destroy', $program) }}" method="POST"
                                            class="delete-form" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete">
                                                <i class='bx bx-trash'></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class='bx bx-book-open'></i>
                                        <div class="empty-state-title">No Programs Found</div>
                                        <div class="empty-state-text">Create a new program to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($programs->hasPages())
                <div class="pagination-wrapper">
                    {{ $programs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
