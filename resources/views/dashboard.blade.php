{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>
    <x-slot name="breadcrumb">Overview</x-slot>

    <style>
        /* Minimalist Dashboard */
        .dashboard-container {
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

        .dashboard-welcome {
            margin-bottom: 24px;
        }

        .welcome-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .welcome-subtitle {
            font-size: 14px;
            color: var(--text-tertiary);
        }

        /* Minimalist Stats */
        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s ease;
            height: 100%;
            position: relative;
        }

        .stat-card:hover {
            border-color: var(--acc-primary);
            box-shadow: var(--shadow-sm);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--card-color);
            border-radius: 12px 12px 0 0;
        }

        .stat-card.primary {
            --card-color: #1e40af;
        }

        .stat-card.success {
            --card-color: #059669;
        }

        .stat-card.info {
            --card-color: #0891b2;
        }

        .stat-card.warning {
            --card-color: #f59e0b;
        }

        .stat-card.danger {
            --card-color: #dc2626;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-tertiary);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--bg-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--card-color);
        }

        .stat-icon i {
            font-size: 20px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-change {
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stat-change.positive {
            color: #059669;
        }

        .stat-change.negative {
            color: #dc2626;
        }

        /* Minimalist Info Card */
        .info-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
        }

        .info-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card-title i {
            font-size: 18px;
            color: var(--acc-primary);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 12px;
            background: #f0fdf4;
            color: #059669;
            font-size: 11px;
            font-weight: 600;
        }

        .status-badge i {
            font-size: 12px;
        }

        .info-card-body {
            padding: 20px;
        }

        /* Minimalist Semester Details */
        .semester-detail {
            display: flex;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            background: var(--bg-primary);
            margin-bottom: 12px;
            transition: all 0.2s;
        }

        .semester-detail:last-child {
            margin-bottom: 0;
        }

        .semester-detail:hover {
            background: #eff6ff;
        }

        .semester-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--acc-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .semester-icon i {
            font-size: 18px;
        }

        .semester-content {
            flex: 1;
            min-width: 0;
        }

        .semester-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-tertiary);
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .semester-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
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

        /* Minimalist Quick Actions */
        .quick-action {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 8px;
            background: var(--bg-primary);
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.2s;
            margin-bottom: 8px;
        }

        .quick-action:last-child {
            margin-bottom: 0;
        }

        .quick-action:hover {
            background: #eff6ff;
            transform: translateX(4px);
        }

        .quick-action-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--acc-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .quick-action-icon i {
            font-size: 20px;
        }

        .quick-action-content {
            flex: 1;
            min-width: 0;
        }

        .quick-action-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .quick-action-desc {
            font-size: 11px;
            color: var(--text-tertiary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 20px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-value {
                font-size: 28px;
            }

            .info-card-body {
                padding: 16px;
            }
        }

        @media (max-width: 576px) {
            .stat-header {
                flex-direction: column;
                gap: 12px;
            }

            .stat-value {
                font-size: 24px;
            }
        }
    </style>

    

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="dashboard-welcome">
            <h1 class="welcome-title">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="welcome-subtitle">Here's your schedule overview</p>
        </div>

        @if (auth()->user()->isAdmin())
            <!-- Stats Grid -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card primary">
                        <div class="stat-header">
                            <span class="stat-label">Schedules</span>
                            <div class="stat-icon">
                                <i class='bx bx-calendar'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalSchedules }}</div>
                        <div class="stat-change positive">
                            <i class='bx bx-trending-up'></i>
                            Active schedules
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card success">
                        <div class="stat-header">
                            <span class="stat-label">Sections</span>
                            <div class="stat-icon">
                                <i class='bx bx-group'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $activeSections }}</div>
                        <div class="stat-change positive">
                            <i class='bx bx-check'></i>
                            Running sections
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card info">
                        <div class="stat-header">
                            <span class="stat-label">Faculty</span>
                            <div class="stat-icon">
                                <i class='bx bx-user-pin'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalFaculty }}</div>
                        <div class="stat-change positive">
                            <i class='bx bx-check'></i>
                            Active faculty
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card {{ $unresolvedConflicts > 0 ? 'danger' : 'warning' }}">
                        <div class="stat-header">
                            <span class="stat-label">Conflicts</span>
                            <div class="stat-icon">
                                <i class='bx bx-error'></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $unresolvedConflicts }}</div>
                        <div class="stat-change {{ $unresolvedConflicts > 0 ? 'negative' : 'positive' }}">
                            <i class='bx bx-{{ $unresolvedConflicts > 0 ? 'error' : 'check' }}'></i>
                            {{ $unresolvedConflicts > 0 ? 'Needs attention' : 'All clear' }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content Grid -->
        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="info-card">
                    <div class="info-card-header">
                        <h3 class="info-card-title">
                            <i class='bx bx-calendar'></i>
                            Current Semester
                        </h3>
                        @if ($currentSemester)
                            <span class="status-badge">
                                <i class='bx bx-check-circle'></i>
                                Active
                            </span>
                        @endif
                    </div>
                    <div class="info-card-body">
                        @if ($currentSemester)
                            <div class="semester-detail">
                                <div class="semester-icon">
                                    <i class='bx bx-book'></i>
                                </div>
                                <div class="semester-content">
                                    <div class="semester-label">Semester</div>
                                    <div class="semester-value">{{ $currentSemester->name }}</div>
                                </div>
                            </div>

                            <div class="semester-detail">
                                <div class="semester-icon">
                                    <i class='bx bx-calendar-alt'></i>
                                </div>
                                <div class="semester-content">
                                    <div class="semester-label">Academic Year</div>
                                    <div class="semester-value">{{ $currentSemester->academicYear->code }}</div>
                                </div>
                            </div>


                            <div class="semester-detail">
                                <div class="semester-icon">
                                    <i class='bx bx-calendar'></i>
                                </div>
                                <div class="semester-content">
                                    <div class="semester-label">Duration</div>
                                    <div class="semester-value">
                                        {{ $currentSemester->start_date->format('M d, Y') }} -
                                        {{ $currentSemester->end_date->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            <div class="semester-detail">
                                <div class="semester-icon">
                                    <i class='bx bx-user-plus'></i>
                                </div>
                                <div class="semester-content">
                                    <div class="semester-label">Enrollment Period</div>
                                    <div class="semester-value">
                                        {{ $currentSemester->enrollment_start->format('M d') }} -
                                        {{ $currentSemester->enrollment_end->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class='bx bx-calendar-x'></i>
                                <div class="empty-state-title">No Active Semester</div>
                                <div class="empty-state-text">Contact administrator to set up a semester</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if (auth()->user()->isAdmin())
                <div class="col-12 col-lg-4">
                    <div class="info-card">
                        <div class="info-card-header">
                            <h3 class="info-card-title">
                                <i class='bx bx-zap'></i>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="info-card-body">
                            <a href="{{ route('schedules.create') }}" class="quick-action">
                                <div class="quick-action-icon">
                                    <i class='bx bx-plus'></i>
                                </div>
                                <div class="quick-action-content">
                                    <div class="quick-action-title">New Schedule</div>
                                    <div class="quick-action-desc">Create class schedule</div>
                                </div>
                            </a>

                            <a href="{{ route('sections.index') }}" class="quick-action">
                                <div class="quick-action-icon">
                                    <i class='bx bx-group'></i>
                                </div>
                                <div class="quick-action-content">
                                    <div class="quick-action-title">Manage Sections</div>
                                    <div class="quick-action-desc">View and edit sections</div>
                                </div>
                            </a>

                            <a href="{{ route('reports.index') }}" class="quick-action">
                                <div class="quick-action-icon">
                                    <i class='bx bx-bar-chart-alt-2'></i>
                                </div>
                                <div class="quick-action-content">
                                    <div class="quick-action-title">View Reports</div>
                                    <div class="quick-action-desc">Generate system reports</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
