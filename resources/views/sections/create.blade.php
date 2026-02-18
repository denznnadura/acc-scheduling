{{-- resources/views/sections/create.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Create Section</x-slot>
    <x-slot name="breadcrumb">Sections / Create</x-slot>

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
            <h1>Create New Section</h1>
            <p>Fill in the details to create a section</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf

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
                                    {{ old('program_id') == $program->id ? 'selected' : '' }}>
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
                                    {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
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
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="e.g., BSIT 1-A" required>
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
                            <option value="1" {{ old('year_level') == 1 ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('year_level') == 2 ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('year_level') == 3 ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('year_level') == 4 ? 'selected' : '' }}>4th Year</option>
                        </select>
                        @error('year_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="capacity" class="form-label">
                            Capacity <span class="required">*</span>
                        </label>
                        <input type="number" name="capacity" id="capacity"
                            class="form-control @error('capacity') is-invalid @enderror"
                            value="{{ old('capacity', 40) }}" min="1" max="100" required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="adviser_id" class="form-label">Section Adviser</label>
                        <select name="adviser_id" id="adviser_id"
                            class="form-select @error('adviser_id') is-invalid @enderror">
                            <option value="">Select Adviser</option>
                            @foreach ($faculty as $fac)
                                <option value="{{ $fac->id }}"
                                    {{ old('adviser_id') == $fac->id ? 'selected' : '' }}>
                                    {{ $fac->user->name }} - {{ $fac->employee_id }}
                                </option>
                            @endforeach
                        </select>
                        @error('adviser_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Section is Active</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-check'></i>
                        Create Section
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
