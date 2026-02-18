{{-- resources/views/faculty/create.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Add Faculty</x-slot>
    <x-slot name="breadcrumb">Faculty / Create</x-slot>

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
            <h1>Add New Faculty Member</h1>
            <p>Fill in the faculty member details</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('faculty.store') }}" method="POST">
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

                <!-- Employment Information -->
                <h3 class="section-title">Employment Information</h3>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="employee_id" class="form-label">
                            Employee ID <span class="required">*</span>
                        </label>
                        <input type="text" name="employee_id" id="employee_id"
                            class="form-control @error('employee_id') is-invalid @enderror"
                            value="{{ old('employee_id') }}" required>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="department_id" class="form-label">
                            Department <span class="required">*</span>
                        </label>
                        <select name="department_id" id="department_id"
                            class="form-select @error('department_id') is-invalid @enderror" required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="position" class="form-label">
                            Position <span class="required">*</span>
                        </label>
                        <select name="position" id="position"
                            class="form-select @error('position') is-invalid @enderror" required>
                            <option value="">Select Position</option>
                            <option value="full_time" {{ old('position') == 'full_time' ? 'selected' : '' }}>Full Time
                            </option>
                            <option value="part_time" {{ old('position') == 'part_time' ? 'selected' : '' }}>Part Time
                            </option>
                            <option value="visiting" {{ old('position') == 'visiting' ? 'selected' : '' }}>Visiting
                            </option>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="rank" class="form-label">Rank</label>
                        <input type="text" name="rank" id="rank"
                            class="form-control @error('rank') is-invalid @enderror" value="{{ old('rank') }}"
                            placeholder="e.g., Instructor, Professor">
                        @error('rank')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="max_units" class="form-label">
                            Maximum Units <span class="required">*</span>
                        </label>
                        <input type="number" name="max_units" id="max_units"
                            class="form-control @error('max_units') is-invalid @enderror"
                            value="{{ old('max_units', 24) }}" min="1" max="30" required>
                        @error('max_units')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="max_preparations" class="form-label">
                            Maximum Preparations <span class="required">*</span>
                        </label>
                        <input type="number" name="max_preparations" id="max_preparations"
                            class="form-control @error('max_preparations') is-invalid @enderror"
                            value="{{ old('max_preparations', 5) }}" min="1" max="10" required>
                        @error('max_preparations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Specializations</label>
                        <input type="text" name="specializations[]" class="form-control mb-2"
                            placeholder="Specialization 1">
                        <input type="text" name="specializations[]" class="form-control mb-2"
                            placeholder="Specialization 2">
                        <input type="text" name="specializations[]" class="form-control"
                            placeholder="Specialization 3">
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Faculty Member is Active</label>
                        </div>
                    </div>
                </div>

                <!-- Info Alert -->
                <div class="info-alert">
                    <i class='bx bx-info-circle'></i>
                    <div>
                        Default password will be set to <strong>password</strong>. Faculty member should change it after
                        first login.
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-check'></i>
                        Add Faculty
                    </button>
                    <a href="{{ route('faculty.index') }}" class="cancel-btn">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
