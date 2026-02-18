{{-- resources/views/rooms/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Rooms</x-slot>
    <x-slot name="breadcrumb">Manage Rooms</x-slot>

    <style>
        /* Minimalist Rooms Page */
        .rooms-container {
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

        .rooms-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rooms-table thead {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .rooms-table thead th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
            text-align: left;
            white-space: nowrap;
        }

        .rooms-table tbody td {
            padding: 16px;
            font-size: 13px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        .rooms-table tbody tr {
            transition: background 0.2s;
        }

        .rooms-table tbody tr:hover {
            background: var(--bg-primary);
        }

        .rooms-table tbody tr:last-child td {
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

            .rooms-table thead th {
                padding: 10px 12px;
                font-size: 10px;
            }

            .rooms-table tbody td {
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

    <div class="rooms-container">
        <!-- Header -->
        <div class="page-actions">
            <h1>Rooms</h1>
            <a href="{{ route('rooms.create') }}" class="create-btn">
                <i class='bx bx-plus'></i>
                Create Room
            </a>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-wrapper">
                <table class="rooms-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Capacity</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td><strong>{{ $room->code }}</strong></td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->building }}</td>
                                <td>{{ $room->floor }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>
                                    <span class="badge type">
                                        {{ ucwords(str_replace('_', ' ', $room->type)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $room->is_active ? 'active' : 'inactive' }}">
                                        <i class='bx bx-{{ $room->is_active ? 'check-circle' : 'x-circle' }}'></i>
                                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('rooms.edit', $room) }}" class="action-btn edit">
                                            <i class='bx bx-edit'></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('rooms.destroy', $room) }}" method="POST"
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
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class='bx bx-door-open'></i>
                                        <div class="empty-state-title">No Rooms Found</div>
                                        <div class="empty-state-text">Create a new room to get started</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($rooms->hasPages())
                <div class="pagination-wrapper">
                    {{ $rooms->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
