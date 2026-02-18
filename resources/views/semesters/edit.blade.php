{{-- resources/views/semesters/edit.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Edit Semester</x-slot>
    <x-slot name="breadcrumb">Semesters / Edit</x-slot>

    <style>
        /* Minimalist Form */
        .form-container {
            max-width: 900px;
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

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 0;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--acc-primary);
            border-color: var(--acc-primary);
        }

        .form-check-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            cursor: pointer;
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
    </style>

    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <h1>Edit Semester</h1>
            <p>Update semester information</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('semesters.update', $semester) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="academic_year_id" class="form-label">
                            Academic Year <span class="required">*</span>
                        </label>
                        <select name="academic_year_id" id="academic_year_id"
                            class="form-select @error('academic_year_id') is-invalid @enderror" required>
                            <option value="">Select Academic Year</option>
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}"
                                    {{ old('academic_year_id', $semester->academic_year_id) == $year->id ? 'selected' : '' }}>
                                    {{ $year->code }}
                                </option>
                            @endforeach
                        </select>
                        @error('academic_year_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label">
                            Semester Name <span class="required">*</span>
                        </label>
                        <select name="name" id="name" class="form-select @error('name') is-invalid @enderror"
                            required>
                            <option value="">Select Semester</option>
                            <option value="1st Semester"
                                {{ old('name', $semester->name) == '1st Semester' ? 'selected' : '' }}>1st Semester
                            </option>
                            <option value="2nd Semester"
                                {{ old('name', $semester->name) == '2nd Semester' ? 'selected' : '' }}>2nd Semester
                            </option>
                            <option value="Summer" {{ old('name', $semester->name) == 'Summer' ? 'selected' : '' }}>
                                Summer</option>
                            <option value="Midyear" {{ old('name', $semester->name) == 'Midyear' ? 'selected' : '' }}>
                                Midyear</option>
                        </select>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="start_date" class="form-label">
                            Start Date <span class="required">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', $semester->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="end_date" class="form-label">
                            End Date <span class="required">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date"
                            class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', $semester->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="enrollment_start" class="form-label">
                            Enrollment Start <span class="required">*</span>
                        </label>
                        <input type="date" name="enrollment_start" id="enrollment_start"
                            class="form-control @error('enrollment_start') is-invalid @enderror"
                            value="{{ old('enrollment_start', $semester->enrollment_start->format('Y-m-d')) }}"
                            required>
                        @error('enrollment_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="enrollment_end" class="form-label">
                            Enrollment End <span class="required">*</span>
                        </label>
                        <input type="date" name="enrollment_end" id="enrollment_end"
                            class="form-control @error('enrollment_end') is-invalid @enderror"
                            value="{{ old('enrollment_end', $semester->enrollment_end->format('Y-m-d')) }}" required>
                        @error('enrollment_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                value="1" {{ old('is_active', $semester->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Set as Active Semester</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-check'></i>
                        Update Semester
                    </button>
                    <a href="{{ route('semesters.index') }}" class="cancel-btn">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
