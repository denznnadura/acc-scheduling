{{-- resources/views/rooms/edit.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Edit Room</x-slot>
    <x-slot name="breadcrumb">Rooms / Edit</x-slot>

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

        .facilities-section {
            margin: 24px 0 16px 0;
        }

        .facilities-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            margin-bottom: 12px;
            display: block;
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
            <h1>Edit Room</h1>
            <p>Update room information</p>
        </div>

        <!-- Form -->
        <div class="form-card">
            <form action="{{ route('rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="code" class="form-label">
                            Room Code <span class="required">*</span>
                        </label>
                        <input type="text" name="code" id="code"
                            class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code', $room->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label">
                            Room Name <span class="required">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $room->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="building" class="form-label">
                            Building <span class="required">*</span>
                        </label>
                        <input type="text" name="building" id="building"
                            class="form-control @error('building') is-invalid @enderror"
                            value="{{ old('building', $room->building) }}" required>
                        @error('building')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="floor" class="form-label">
                            Floor <span class="required">*</span>
                        </label>
                        <input type="text" name="floor" id="floor"
                            class="form-control @error('floor') is-invalid @enderror"
                            value="{{ old('floor', $room->floor) }}" required>
                        @error('floor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="capacity" class="form-label">
                            Capacity <span class="required">*</span>
                        </label>
                        <input type="number" name="capacity" id="capacity"
                            class="form-control @error('capacity') is-invalid @enderror"
                            value="{{ old('capacity', $room->capacity) }}" min="1" required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="type" class="form-label">
                            Type <span class="required">*</span>
                        </label>
                        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror"
                            required>
                            <option value="">Select Type</option>
                            <option value="lecture" {{ old('type', $room->type) == 'lecture' ? 'selected' : '' }}>
                                Lecture Room</option>
                            <option value="laboratory"
                                {{ old('type', $room->type) == 'laboratory' ? 'selected' : '' }}>Laboratory</option>
                            <option value="computer_lab"
                                {{ old('type', $room->type) == 'computer_lab' ? 'selected' : '' }}>Computer Lab
                            </option>
                            <option value="workshop" {{ old('type', $room->type) == 'workshop' ? 'selected' : '' }}>
                                Workshop</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="facilities-section">
                            <label class="facilities-label">Facilities</label>
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="facilities[]" value="projector"
                                            class="form-check-input" id="projector"
                                            {{ in_array('projector', $room->facilities ?? []) ? 'checked' : '' }}>
                                        <label for="projector" class="form-check-label">Projector</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="facilities[]" value="aircon"
                                            class="form-check-input" id="aircon"
                                            {{ in_array('aircon', $room->facilities ?? []) ? 'checked' : '' }}>
                                        <label for="aircon" class="form-check-label">Air Con</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="facilities[]" value="whiteboard"
                                            class="form-check-input" id="whiteboard"
                                            {{ in_array('whiteboard', $room->facilities ?? []) ? 'checked' : '' }}>
                                        <label for="whiteboard" class="form-check-label">Whiteboard</label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="facilities[]" value="computers"
                                            class="form-check-input" id="computers"
                                            {{ in_array('computers', $room->facilities ?? []) ? 'checked' : '' }}>
                                        <label for="computers" class="form-check-label">Computers</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                value="1" {{ old('is_active', $room->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Room is Active</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class='bx bx-check'></i>
                        Update Room
                    </button>
                    <a href="{{ route('rooms.index') }}" class="cancel-btn">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
