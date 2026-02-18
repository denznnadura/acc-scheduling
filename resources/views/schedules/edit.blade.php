{{-- resources/views/schedules/edit.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Edit Schedule</x-slot>
    <x-slot name="breadcrumb">Schedules / Edit</x-slot>

    <style>
        /* Minimalist Form */
        .form-container {
            max-width: 1000px;
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

        .form-header {
            margin-bottom: 24px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .form-header p {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        .form-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 24px 0 16px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-light);
        }

        .section-title:first-child {
            margin-top: 0;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            margin-bottom: 6px;
            display: block;
        }

        .required {
            color: #dc2626;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            color: var(--text-primary);
            transition: all 0.2s;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--acc-primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            outline: none;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc2626;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .invalid-feedback {
            font-size: 11px;
            color: #dc2626;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .invalid-feedback::before {
            content: '\ea0d';
            font-family: 'boxicons';
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            padding-top: 20px;
            margin-top: 24px;
            border-top: 1px solid var(--border-light);
        }

        .submit-btn {
            background: var(--acc-primary);
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            color: white;
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .submit-btn:hover {
            background: var(--acc-light-blue);
        }

        .submit-btn i {
            font-size: 16px;
        }

        .cancel-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 24px;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .cancel-btn:hover {
            border-color: #dc2626;
            color: #dc2626;
        }

        .cancel-btn i {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 20px;
            }

            .form-header h1 {
                font-size: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .submit-btn,
            .cancel-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Day Radio Boxes */
        .day-radio-box {
            padding: 10px 12px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .day-radio-box:hover {
            background: #eff6ff;
            border-color: var(--acc-primary);
        }

        .day-radio-box:has(.day-radio:checked) {
            background: #dbeafe;
            border-color: var(--acc-primary);
        }

        .day-radio {
            width: 18px;
            height: 18px;
            border: 1px solid var(--border-color);
            cursor: pointer;
        }

        .day-radio:checked {
            background-color: var(--acc-primary);
            border-color: var(--acc-primary);
        }

        .day-radio-box .form-check-label {
            cursor: pointer;
            user-select: none;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            margin: 0;
        }
    </style>

    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <h1>Edit Schedule</h1>
            <p>Update class schedule information</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('schedules.update', $schedule) }}" method="POST" id="scheduleEditForm">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <h3 class="section-title">Basic Information</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="semester_id" class="form-label">
                            Semester <span class="required">*</span>
                        </label>
                        <select name="semester_id" id="semester_id"
                            class="form-select @error('semester_id') is-invalid @enderror" required>
                            <option value="">Select Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ old('semester_id', $schedule->semester_id) == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }} ({{ $semester->academicYear->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="section_id" class="form-label">
                            Section <span class="required">*</span>
                        </label>
                        <select name="section_id" id="section_id"
                            class="form-select @error('section_id') is-invalid @enderror" required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id', $schedule->section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }} - {{ $section->program->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="course_id" class="form-label">
                            Course <span class="required">*</span>
                        </label>
                        <select name="course_id" id="course_id"
                            class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id', $schedule->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->code }} - {{ $course->name }} ({{ $course->units }} units)
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="type" class="form-label">
                            Class Type <span class="required">*</span>
                        </label>
                        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror"
                            required>
                            <option value="">Select Type</option>
                            <option value="lecture" {{ old('type', $schedule->type) == 'lecture' ? 'selected' : '' }}>
                                Lecture</option>
                            <option value="laboratory"
                                {{ old('type', $schedule->type) == 'laboratory' ? 'selected' : '' }}>Laboratory
                            </option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Assignment -->
                <h3 class="section-title">Faculty & Room</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="faculty_id" class="form-label">
                            Faculty <span class="required">*</span>
                        </label>
                        <select name="faculty_id" id="faculty_id"
                            class="form-select @error('faculty_id') is-invalid @enderror" required>
                            <option value="">Select Faculty</option>
                            @foreach ($faculty as $fac)
                                <option value="{{ $fac->id }}"
                                    {{ old('faculty_id', $schedule->faculty_id) == $fac->id ? 'selected' : '' }}>
                                    {{ $fac->user->name }} - {{ $fac->employee_id }}
                                </option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="room_id" class="form-label">
                            Room <span class="required">*</span>
                        </label>
                        <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror"
                            required>
                            <option value="">Select Room</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{ old('room_id', $schedule->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->code }} - {{ $room->name }} ({{ $room->capacity }} capacity)
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Schedule Details -->
                <h3 class="section-title">Schedule Details</h3>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">
                            Day <span class="required">*</span>
                        </label>
                        <div class="row g-2">
                            @foreach ($days as $day)
                                <div class="col-6 col-md-4 col-lg-2">
                                    <div class="form-check day-radio-box">
                                        <input type="radio" name="day" value="{{ $day }}"
                                            id="day_{{ $day }}" class="form-check-input day-radio"
                                            {{ old('day', $schedule->day) == $day ? 'checked' : '' }} required>
                                        <label for="day_{{ $day }}" class="form-check-label">
                                            {{ $day }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('day')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="start_time" class="form-label">
                            Start Time <span class="required">*</span>
                        </label>
                        <select name="start_time" id="start_time"
                            class="form-select @error('start_time') is-invalid @enderror" required>
                            <option value="">Select Time</option>
                            @foreach ($times as $time)
                                <option value="{{ $time }}"
                                    {{ old('start_time', date('H:i', strtotime($schedule->start_time))) == $time ? 'selected' : '' }}>
                                    {{ date('g:i A', strtotime($time)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="end_time" class="form-label">
                            End Time <span class="required">*</span>
                        </label>
                        <select name="end_time" id="end_time"
                            class="form-select @error('end_time') is-invalid @enderror" required>
                            <option value="">Select Time</option>
                            @foreach ($times as $time)
                                <option value="{{ $time }}"
                                    {{ old('end_time', date('H:i', strtotime($schedule->end_time))) == $time ? 'selected' : '' }}>
                                    {{ date('g:i A', strtotime($time)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <!-- Additional Details -->
                <h3 class="section-title">Additional Details</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="max_students" class="form-label">
                            Maximum Students <span class="required">*</span>
                        </label>
                        <input type="number" name="max_students" id="max_students"
                            class="form-control @error('max_students') is-invalid @enderror"
                            value="{{ old('max_students', $schedule->max_students) }}" min="1" required>
                        @error('max_students')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="status" class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <select name="status" id="status"
                            class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active"
                                {{ old('status', $schedule->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="cancelled"
                                {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="completed"
                                {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror"
                            placeholder="Add any additional notes...">{{ old('notes', $schedule->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-check'></i>
                        Update Schedule
                    </button>
                    <a href="{{ route('schedules.index') }}" class="cancel-btn">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('scheduleEditForm').addEventListener('change', function(e) {
                if (['start_time', 'end_time', 'faculty_id', 'room_id', 'semester_id'].includes(e.target.id) ||
                    e.target.classList.contains('day-radio')) {
                    checkAvailability();
                }
            });

            function checkAvailability() {
                const selectedDay = document.querySelector('.day-radio:checked');

                if (!selectedDay) return;

                const data = {
                    faculty_id: document.getElementById('faculty_id').value,
                    room_id: document.getElementById('room_id').value,
                    day: selectedDay.value,
                    start_time: document.getElementById('start_time').value,
                    end_time: document.getElementById('end_time').value,
                    semester_id: document.getElementById('semester_id').value,
                    exclude_id: {{ $schedule->id }},
                    _token: '{{ csrf_token() }}'
                };

                if (Object.values(data).every(x => x !== '')) {
                    fetch('{{ route('schedules.check-availability') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (!result.available) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Conflict Detected',
                                    html: '<ul style="text-align: left; margin: 0; padding-left: 20px;">' +
                                        result.conflicts.map(c => '<li>' + c + '</li>').join('') +
                                        '</ul>',
                                    confirmButtonColor: '#1e40af'
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            }
        </script>
    @endpush
</x-app-layout>
