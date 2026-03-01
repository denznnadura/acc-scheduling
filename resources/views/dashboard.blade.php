<x-app-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>
    <x-slot name="breadcrumb">Overview</x-slot>

    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dashboard-welcome { margin-bottom: 24px; }
        .welcome-title { font-size: 24px; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em; margin-bottom: 4px; }
        .welcome-subtitle { font-size: 14px; color: var(--text-tertiary); }

        .stat-link { text-decoration: none; display: block; height: 100%; }
        
        .stat-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        a.stat-link:hover .stat-card {
            border-color: var(--acc-primary);
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: var(--card-color);
            border-radius: 12px 12px 0 0;
        }

        .stat-card.primary { --card-color: #1e40af; }
        .stat-card.success { --card-color: #059669; }
        .stat-card.info { --card-color: #0891b2; }
        .stat-card.warning { --card-color: #f59e0b; }
        .stat-card.danger { --card-color: #dc2626; }

        .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; }
        .stat-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary); }
        .stat-icon { 
            width: 40px; height: 40px; border-radius: 8px; background: var(--bg-primary); 
            display: flex; align-items: center; justify-content: center; color: var(--card-color);
            transition: transform 0.3s ease;
        }

        a.stat-link:hover .stat-icon { transform: scale(1.1); }
        .stat-value { font-size: 32px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px; }
        .stat-change { font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 4px; }
        .stat-change.positive { color: #059669; }
        .stat-change.negative { color: #dc2626; }

        .info-card { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; height: 100%; }
        .info-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center; }
        .info-card-title { font-size: 14px; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 8px; }
        .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 12px; background: #f0fdf4; color: #059669; font-size: 11px; font-weight: 600; }
        .info-card-body { padding: 20px; }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .course-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 16px;
            transition: all 0.2s ease;
        }

        .course-card:hover {
            border-color: var(--acc-primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .course-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .course-code-badge {
            font-size: 14px;
            font-weight: 800;
            color: var(--acc-primary);
            background: rgba(30, 64, 175, 0.05);
            padding: 4px 10px;
            border-radius: 6px;
        }

        .section-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .section-btn {
            text-decoration: none;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-primary);
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .section-btn:hover {
            background: var(--acc-primary);
            color: white;
            border-color: var(--acc-primary);
            transform: translateY(-2px);
        }

        .semester-detail { display: flex; gap: 12px; padding: 12px; border-radius: 8px; background: var(--bg-primary); margin-bottom: 12px; transition: all 0.2s; }
        .semester-detail:hover { background: #eff6ff; }
        .semester-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--acc-primary); display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; }
        .semester-label { font-size: 11px; font-weight: 600; text-transform: uppercase; color: var(--text-tertiary); margin-bottom: 4px; }
        .semester-value { font-size: 14px; font-weight: 600; color: var(--text-primary); }

        .quick-action { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; background: var(--bg-primary); text-decoration: none; color: var(--text-primary); transition: all 0.2s; margin-bottom: 8px; }
        .quick-action:hover { background: #eff6ff; transform: translateX(4px); }
        .quick-action-icon { width: 40px; height: 40px; border-radius: 8px; background: var(--acc-primary); display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0; }
        .quick-action-title { font-size: 13px; font-weight: 600; margin-bottom: 2px; }
        .quick-action-desc { font-size: 11px; color: var(--text-tertiary); }

        @media (max-width: 768px) { .welcome-title { font-size: 20px; } .stat-value { font-size: 28px; } }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-welcome">
            <h1 class="welcome-title">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="welcome-subtitle">Here's your schedule overview</p>
        </div>

        @if (auth()->user()->isAdmin())
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('schedules.index') }}" class="stat-link">
                        <div class="stat-card primary">
                            <div class="stat-header">
                                <span class="stat-label">Schedules</span>
                                <div class="stat-icon"><i class='bx bx-calendar'></i></div>
                            </div>
                            <div class="stat-value">{{ $totalSchedules }}</div>
                            <div class="stat-change positive"><i class='bx bx-trending-up'></i>Active schedules</div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('sections.index') }}" class="stat-link">
                        <div class="stat-card success">
                            <div class="stat-header">
                                <span class="stat-label">Sections</span>
                                <div class="stat-icon"><i class='bx bx-group'></i></div>
                            </div>
                            <div class="stat-value">{{ $activeSections }}</div>
                            <div class="stat-change positive"><i class='bx bx-check'></i>Running sections</div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <a href="{{ route('faculty.index') }}" class="stat-link">
                        <div class="stat-card info">
                            <div class="stat-header">
                                <span class="stat-label">Faculty</span>
                                <div class="stat-icon"><i class='bx bx-user-pin'></i></div>
                            </div>
                            <div class="stat-value">{{ $totalFaculty }}</div>
                            <div class="stat-change positive"><i class='bx bx-check'></i>Active faculty</div>
                        </div>
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    @if($unresolvedConflicts > 0)
                        <a href="{{ route('schedules.index', ['filter' => 'conflicts']) }}" class="stat-link">
                    @else
                        <div class="stat-link">
                    @endif
                        <div class="stat-card {{ $unresolvedConflicts > 0 ? 'danger' : 'warning' }}">
                            <div class="stat-header">
                                <span class="stat-label">Conflicts</span>
                                <div class="stat-icon"><i class='bx bx-error'></i></div>
                            </div>
                            <div class="stat-value">{{ $unresolvedConflicts }}</div>
                            <div class="stat-change {{ $unresolvedConflicts > 0 ? 'negative' : 'positive' }}">
                                <i class='bx bx-{{ $unresolvedConflicts > 0 ? 'error' : 'check' }}'></i>
                                {{ $unresolvedConflicts > 0 ? 'Needs attention' : 'All clear' }}
                            </div>
                        </div>
                    @if($unresolvedConflicts > 0)
                        </a>
                    @else
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="row g-3">
            <div class="col-12 col-lg-8">
                <div class="info-card">
                    <div class="info-card-header">
                        <h3 class="info-card-title"><i class='bx bx-grid-alt'></i>Class Schedules by Course</h3>
                    </div>
                    <div class="info-card-body">
                        <div class="course-grid">
                            @foreach ($courses as $course)
                                <div class="course-card">
                                    <div class="course-header">
                                        <span class="course-code-badge">{{ $course->code }}</span>
                                        <small class="text-muted">{{ $course->sections->count() }} Sections</small>
                                    </div>
                                    <div class="section-container">
                                        @foreach ($course->sections as $section)
                                            <a href="{{ route('schedules.index', ['section_id' => $section->id]) }}" class="section-btn">
                                                {{ $section->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="info-card mb-3">
                    <div class="info-card-header">
                        <h3 class="info-card-title"><i class='bx bx-calendar'></i>Current Semester</h3>
                        @if ($currentSemester)
                            <span class="status-badge"><i class='bx bx-check-circle'></i>Active</span>
                        @endif
                    </div>
                    <div class="info-card-body">
                        @if ($currentSemester)
                            <div class="semester-detail">
                                <div class="semester-icon"><i class='bx bx-book'></i></div>
                                <div class="semester-content">
                                    <div class="semester-label">Semester</div>
                                    <div class="semester-value">{{ $currentSemester->name }}</div>
                                </div>
                            </div>
                            <div class="semester-detail">
                                <div class="semester-icon"><i class='bx bx-calendar-alt'></i></div>
                                <div class="semester-content">
                                    <div class="semester-label">Academic Year</div>
                                    <div class="semester-value">{{ $currentSemester->academicYear->code }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class='bx bx-calendar-x text-muted' style="font-size: 40px;"></i>
                                <p class="text-muted small mt-2">No active semester</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if (auth()->user()->isAdmin())
                    <div class="info-card">
                        <div class="info-card-header">
                            <h3 class="info-card-title"><i class='bx bx-zap'></i>Quick Actions</h3>
                        </div>
                        <div class="info-card-body">
                            <a href="{{ route('schedules.create') }}" class="quick-action">
                                <div class="quick-action-icon"><i class='bx bx-plus'></i></div>
                                <div class="quick-action-content">
                                    <div class="quick-action-title">New Schedule</div>
                                    <div class="quick-action-desc">Create class schedule</div>
                                </div>
                            </a>
                            <a href="{{ route('sections.index') }}" class="quick-action">
                                <div class="quick-action-icon"><i class='bx bx-group'></i></div>
                                <div class="quick-action-content">
                                    <div class="quick-action-title">Manage Sections</div>
                                    <div class="quick-action-desc">View and edit sections</div>
                                </div>
                            </a>
                            <a href="{{ route('reports.index') }}" class="quick-action">
                                <div class="quick-action-icon"><i class='bx bx-bar-chart-alt-2'></i></div>
                                <div class="quick-action-content">
                                    <div class="quick-action-title">View Reports</div>
                                    <div class="quick-action-desc">Generate system reports</div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>