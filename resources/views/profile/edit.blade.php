{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="pageTitle">Profile</x-slot>
    <x-slot name="breadcrumb">My Profile</x-slot>

    <style>
        /* Minimalist Profile Page */
        .profile-container {
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

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .page-header p {
            font-size: 13px;
            color: var(--text-tertiary);
        }

        /* Profile Cards */
        .profile-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .card-header {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }

        .card-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .card-header p {
            font-size: 12px;
            color: var(--text-tertiary);
            margin: 0;
        }

        /* Form Styling */
        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-tertiary);
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            color: var(--text-primary);
            transition: all 0.2s;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--acc-primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            outline: none;
        }

        .form-control:disabled {
            background: var(--bg-primary);
            color: var(--text-tertiary);
            cursor: not-allowed;
        }

        .submit-btn {
            background: var(--acc-primary);
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            color: white;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .submit-btn:hover {
            background: var(--acc-light-blue);
        }

        .danger-btn {
            background: #dc2626;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            color: white;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .danger-btn:hover {
            background: #b91c1c;
        }

        .success-message {
            background: #f0fdf4;
            border: 1px solid #86efac;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 13px;
            color: #166534;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .success-message i {
            font-size: 18px;
        }

        .warning-box {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #92400e;
        }

        .warning-box strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 20px;
            }

            .page-header h1 {
                font-size: 20px;
            }
        }
    </style>

    <div class="profile-container">
        <!-- Header -->
        <div class="page-header">
            <h1>Profile Settings</h1>
            <p>Manage your account information and settings</p>
        </div>

        <!-- Update Profile Information -->
        <div class="profile-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="profile-card">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="profile-card">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
