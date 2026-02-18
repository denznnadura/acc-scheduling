{{-- resources/views/sections/edit.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Edit Section</x-slot>
    <x-slot name="breadcrumb">Sections / Edit</x-slot>

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

        /* Form Card */
        .form-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
        }

        /* Section */
        .form-section {
            margin-bottom: 24px;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-light);
        }

        /* Form Labels */
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

        /* Form Controls */
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

        /* Validation */
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

        /* Help Text */
        .form-help {
            font-size: 11px;
            color: var(--text-tertiary);
            margin-top: 4px;
        }

        /* Toggle Switch */
        .toggle-container {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s;
        }

        .toggle-container:hover {
            background: #eff6ff;
            border-color: var(--acc-primary);
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: 0.3s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: var(--acc-primary);
        }

        input:checked+.toggle-slider:before {
            transform: translateX(20px);
        }

        .toggle-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            cursor: pointer;
            user-select: none;
        }

        /* Actions */
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

        /* Responsive */
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
            <h1>Edit Section</h1>
            <p>Update section information and settings</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('sections.update', $section) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">Basic Information</h3>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="program_id" class="form-label">
                                Program <span class="required">*</span>
                            </label>
                            <select name="program_id" id="program_id"
                                class="form-select @error('program_id') is-invalid @enderror" required>
                                <option value="">Select Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ old('program_id', $section->program_id) == $program->id ? 'selected' : '' }}>
                                        {{ $program->code }} - {{ $program->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="semester_id" class="form-label">
                                Semester <span class="required">*</span>
                            </label>
                            <select name="semester_id" id="semester_id"
                                class="form-select @error('semester_id') is-invalid @enderror" required>
                                <option value="">Select Semester</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}"
                                        {{ old('semester_id', $section->semester_id) == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->name }} ({{ $semester->academicYear->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">
                                Section Name <span class="required">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $section->name) }}" placeholder="e.g., BSIT-1A" required>
                            <div class="form-help">Enter unique section identifier</div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="year_level" class="form-label">
                                Year Level <span class="required">*</span>
                            </label>
                            <select name="year_level" id="year_level"
                                class="form-select @error('year_level') is-invalid @enderror" required>
                                <option value="">Select Year</option>
                                <option value="1"
                                    {{ old('year_level', $section->year_level) == 1 ? 'selected' : '' }}>1st Year
                                </option>
                                <option value="2"
                                    {{ old('year_level', $section->year_level) == 2 ? 'selected' : '' }}>2nd Year
                                </option>
                                <option value="3"
                                    {{ old('year_level', $section->year_level) == 3 ? 'selected' : '' }}>3rd Year
                                </option>
                                <option value="4"
                                    {{ old('year_level', $section->year_level) == 4 ? 'selected' : '' }}>4th Year
                                </option>
                            </select>
                            @error('year_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Details -->
                <div class="form-section">
                    <h3 class="section-title">Section Details</h3>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="capacity" class="form-label">
                                Capacity <span class="required">*</span>
                            </label>
                            <input type="number" name="capacity" id="capacity"
                                class="form-control @error('capacity') is-invalid @enderror"
                                value="{{ old('capacity', $section->capacity) }}" min="1" max="100"
                                placeholder="40" required>
                            <div class="form-help">Maximum number of students (1-100)</div>
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="adviser_id" class="form-label">
                                Section Adviser
                            </label>
                            <select name="adviser_id" id="adviser_id"
                                class="form-select @error('adviser_id') is-invalid @enderror">
                                <option value="">No Adviser Assigned</option>
                                @foreach ($faculty as $fac)
                                    <option value="{{ $fac->id }}"
                                        {{ old('adviser_id', $section->adviser_id) == $fac->id ? 'selected' : '' }}>
                                        {{ $fac->user->name }} - {{ $fac->employee_id }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-help">Optional: Assign a faculty adviser</div>
                            @error('adviser_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <div class="toggle-container">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', $section->is_active) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                                <label for="is_active" class="toggle-label">
                                    Section is Active
                                </label>
                            </div>
                            <div class="form-help">Active sections are visible and available for enrollment</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-save'></i>
                        Update Section
                    </button>
                    <a href="{{ route('sections.index') }}" class="cancel-btn">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
