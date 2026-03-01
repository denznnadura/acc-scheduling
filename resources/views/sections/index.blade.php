{{-- resources/views/sections/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Sections</x-slot>
    <x-slot name="breadcrumb">Manage Sections</x-slot>

    <style>
        /* Minimalist Sections Page */
        .sections-container {
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

        .sections-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sections-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .sections-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .sections-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .sections-table tbody tr:hover { background: var(--bg-primary); }
        .sections-table tbody tr:last-child td { border-bottom: none; }

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

        .status-badge.active { background: #f0fdf4; color: #059669; }
        .status-badge.inactive { background: #f9fafb; color: #6b7280; }

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

        .action-btn.edit { background: #fef3c7; color: #92400e; }
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

        .empty-state-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
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
            .action-btn { width: 100%; justify-content: center; }
        }
    </style>

    <div class="sections-container">
        <div class="page-actions">
            <h1>Sections</h1>
            <a href="{{ route('sections.create') }}" class="create-btn">
                <i class='bx bx-plus'></i>
                New Section
            </a>
        </div>

        <div class="table-card">
            <div class="table-wrapper">
                <table class="sections-table">
                    <thead>
                        <tr>
                            <th>Section Name</th>
                            <th>Program</th>
                            <th>Semester</th>
                            <th>Year Level</th>
                            <th>Capacity</th>
                            <th>Adviser</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                            <tr>
                                <td><strong>{{ $section->name }}</strong></td>
                                <td>{{ $section->program->code }}</td>
                                <td>{{ $section->semester->name }}</td>
                                <td>{{ $section->year_level }}</td>
                                <td>{{ $section->capacity }}</td>
                                <td>{{ $section->adviser ? $section->adviser->user->name : 'Not Assigned' }}</td>
                                <td>
                                    <span class="status-badge {{ $section->is_active ? 'active' : 'inactive' }}">
                                        <i class='bx bx-{{ $section->is_active ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ $section->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('sections.edit', $section) }}" class="action-btn edit">
                                            <i class='bx bx-edit'></i>
                                            Edit
                                        </a>
                                        {{-- Delete Button and Form Removed --}}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class='bx bx-group'></i>
                                        <div class="empty-state-title">No Sections Found</div>
                                        <div class="empty-state-text">Create a new section to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($sections->hasPages())
                <div class="pagination-wrapper">
                    {{ $sections->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>