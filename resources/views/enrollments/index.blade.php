{{-- resources/views/enrollments/index.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">My Enrollments</x-slot>
    <x-slot name="breadcrumb">Course Enrollment</x-slot>

    <style>
        /* Enrollment Page */
        .enrollment-container {
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

        /* Section Info Banner */
        .section-info-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.2);
        }

        .banner-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .banner-icon i {
            font-size: 32px;
            color: white;
        }

        .banner-content h2 {
            font-size: 20px;
            font-weight: 700;
            color: white;
            margin-bottom: 4px;
        }

        .banner-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        .banner-stats {
            margin-left: auto;
            display: flex;
            gap: 24px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: white;
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 4px;
        }

        /* Section Headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .units-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Info Alert */
        .info-alert {
            background: #eff6ff;
            border: 1px solid #93c5fd;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: #1e40af;
        }

        .info-alert i {
            font-size: 24px;
            flex-shrink: 0;
        }

        /* Schedule Cards */
        .schedules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .schedule-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.2s;
        }

        .schedule-card:hover {
            border-color: var(--acc-primary);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 16px;
        }

        .course-info h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .course-code {
            background: var(--acc-primary);
            color: white;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .course-units {
            font-size: 12px;
            color: var(--text-tertiary);
            margin-top: 8px;
        }

        .schedule-details {
            border-top: 1px solid var(--border-light);
            padding-top: 16px;
            margin-top: 16px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .detail-row i {
            font-size: 16px;
            color: var(--acc-primary);
            width: 20px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .enrolled-badge {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .enrolled-badge i {
            font-size: 14px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 64px 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }

        .empty-state i {
            font-size: 64px;
            color: var(--text-tertiary);
            opacity: 0.3;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--text-tertiary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .schedules-grid {
                grid-template-columns: 1fr;
            }

            .section-info-banner {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .banner-stats {
                margin-left: 0;
                justify-content: center;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
        }
    </style>

    <div class="enrollment-container">
        <!-- Section Info Banner -->
        <div class="section-info-banner">
            <div class="banner-icon">
                <i class='bx bxs-graduation'></i>
            </div>
            <div class="banner-content">
                <h2>{{ $student->section->name }}</h2>
                <p>{{ $student->program->name }} • Year {{ $student->year_level }} • {{ $currentSemester->name }}
                    ({{ $currentSemester->academicYear->code }})</p>
            </div>
            <div class="banner-stats">
                <div class="stat-item">
                    <div class="stat-value">{{ $enrollments->count() }}</div>
                    <div class="stat-label">Enrolled</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $enrollments->sum(fn($e) => $e->schedule->course->units) }}</div>
                    <div class="stat-label">Total Units</div>
                </div>
            </div>
        </div>

        <!-- Info Alert -->
        <div class="info-alert">
            <i class='bx bx-info-circle'></i>
            <div>
                <strong>Enrollment managed by Admin.</strong> Your course enrollments are handled by the academic
                office. Contact them for enrollment changes.
            </div>
        </div>

        <!-- Enrolled Courses -->
        @if ($enrollments->count() > 0)
            <div class="section-header">
                <h3>My Enrolled Courses</h3>
                <span class="units-badge">
                    {{ $enrollments->sum(fn($e) => $e->schedule->course->units) }} Units Enrolled
                </span>
            </div>

            <div class="schedules-grid">
                @foreach ($enrollments as $enrollment)
                    <div class="schedule-card">
                        <div class="card-header">
                            <div class="course-info">
                                <span class="course-code">{{ $enrollment->schedule->course->code }}</span>
                                <h4>{{ $enrollment->schedule->course->name }}</h4>
                                <div class="course-units">{{ $enrollment->schedule->course->units }} Units</div>
                            </div>
                            <span class="enrolled-badge">
                                <i class='bx bx-check-circle'></i>
                                Enrolled
                            </span>
                        </div>

                        <div class="schedule-details">
                            <div class="detail-row">
                                <i class='bx bx-user'></i>
                                <span><strong>{{ $enrollment->schedule->faculty->user->name }}</strong></span>
                            </div>
                            <div class="detail-row">
                                <i class='bx bx-calendar'></i>
                                <span>{{ $enrollment->schedule->day }}</span>
                            </div>
                            <div class="detail-row">
                                <i class='bx bx-time'></i>
                                <span>{{ date('g:i A', strtotime($enrollment->schedule->start_time)) }} -
                                    {{ date('g:i A', strtotime($enrollment->schedule->end_time)) }}</span>
                            </div>
                            <div class="detail-row">
                                <i class='bx bx-door-open'></i>
                                <span>Room {{ $enrollment->schedule->room->code }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class='bx bx-book'></i>
                <h3>No Enrolled Courses</h3>
                <p>You are not currently enrolled in any courses for this semester. Please contact the academic office
                    for enrollment assistance.</p>
            </div>
        @endif
    </div>
</x-app-layout>
