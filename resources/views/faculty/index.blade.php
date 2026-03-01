{{-- resources/views/faculty/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Faculty</x-slot>
    <x-slot name="breadcrumb">Manage Faculty</x-slot>

    <style>
        /* Minimalist Faculty Page */
        .faculty-container {
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

        .faculty-table {
            width: 100%;
            border-collapse: collapse;
        }

        .faculty-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .faculty-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .faculty-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .faculty-table tbody tr {
            transition: background 0.2s;
        }

        .faculty-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .faculty-table tbody tr:last-child td {
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

        .badge.position {
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

            .faculty-table thead th {
                padding: 10px 12px;
                font-size: 10px;
            }

            .faculty-table tbody td {
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

    <div class="faculty-container">
        <div class="page-actions">
            <h1>Faculty Members</h1>
            <a href="{{ route('faculty.create') }}" class="create-btn">
                <i class='bx bx-plus'></i>
                Add Faculty
            </a>
        </div>

        <div class="table-card">
            <div class="table-wrapper">
                <table class="faculty-table">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Max Units</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faculty as $fac)
                            <tr>
                                <td><strong>{{ $fac->employee_id }}</strong></td>
                                <td>{{ $fac->user->name }}</td>
                                <td>{{ $fac->user->email }}</td>
                                <td>{{ $fac->department->code }}</td>
                                <td>
                                    <span class="badge position">
                                        {{ ucwords(str_replace('_', ' ', $fac->position)) }}
                                    </span>
                                </td>
                                <td>{{ $fac->max_units }}</td>
                                <td>
                                    <span class="badge {{ $fac->is_active ? 'active' : 'inactive' }}">
                                        <i class='bx bx-{{ $fac->is_active ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ $fac->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('faculty.edit', $fac) }}" class="action-btn edit">
                                            <i class='bx bx-edit'></i>
                                            Edit
                                        </a>
                                        {{-- Delete button removed as requested --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class='bx bx-user-pin'></i>
                                        <div class="empty-state-title">No Faculty Members Found</div>
                                        <div class="empty-state-text">Add a faculty member to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($faculty->hasPages())
                <div class="pagination-wrapper">
                    {{ $faculty->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>