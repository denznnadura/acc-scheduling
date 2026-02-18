{{-- resources/views/students/create.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Add Student</x-slot>
    <x-slot name="breadcrumb">Students / Create</x-slot>

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

        .info-alert {
            background: #eff6ff;
            border: 1px solid #93c5fd;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: #1e40af;
        }

        .info-alert i {
            font-size: 20px;
            flex-shrink: 0;
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
            <h1>Add New Student</h1>
            <p>Fill in the student details</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <!-- Personal Information -->
                <h3 class="section-title">Personal Information</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label">
                            Full Name <span class="required">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                            placeholder="e.g., 09123456789">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address"
                            class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Academic Information -->
                <h3 class="section-title">Academic Information</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="student_id" class="form-label">
                            Student ID <span class="required">*</span>
                        </label>
                        <input type="text" name="student_id" id="student_id"
                            class="form-control @error('student_id') is-invalid @enderror"
                            value="{{ old('student_id') }}" required>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                        <label for="section_id" class="form-label">
                            Section <span class="required">*</span>
                        </label>
                        <select name="section_id" id="section_id"
                            class="form-select @error('section_id') is-invalid @enderror" required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }} ({{ $section->program->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>




                    <div class="col-12 col-md-4">
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

                    <div class="col-12 col-md-4">
                        <label for="status" class="form-label">
                            Status <span class="required">*</span>
                        </label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="">Select Status</option>
                            <option value="regular" {{ old('status') == 'regular' ? 'selected' : '' }}>Regular
                            </option>
                            <option value="irregular" {{ old('status') == 'irregular' ? 'selected' : '' }}>Irregular
                            </option>
                            <option value="probation" {{ old('status') == 'probation' ? 'selected' : '' }}>Probation
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="enrollment_date" class="form-label">
                            Enrollment Date <span class="required">*</span>
                        </label>
                        <input type="date" name="enrollment_date" id="enrollment_date"
                            class="form-control @error('enrollment_date') is-invalid @enderror"
                            value="{{ old('enrollment_date', date('Y-m-d')) }}" required>
                        @error('enrollment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Student is Active</label>
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="info-alert">
                    <i class='bx bx-info-circle'></i>
                    <div>
                        Default password will be set to <strong>password</strong>. Student should change it after first
                        login.
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-check'></i>
                        Add Student
                    </button>
                    <a href="{{ route('students.index') }}" class="cancel-btn">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
