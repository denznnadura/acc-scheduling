<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - Aklan Catholic College</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --acc-primary: #1e40af;
            --acc-light-blue: #3b82f6;
            --acc-green: #059669;
            --text-primary: #1f2937;
            --text-secondary: #4b5563;
            --text-tertiary: #6b7280;
            --bg-primary: #f9fafb;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            width: 100%;
            max-width: 480px;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reset-card {
            background: white;
            border-radius: 16px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 16px;
        }

        .logo-container h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }

        .logo-container p {
            font-size: 14px;
            color: var(--text-tertiary);
        }

        .info-box {
            background: #eff6ff;
            border: 2px solid #93c5fd;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .info-box i {
            font-size: 24px;
            color: var(--acc-primary);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-box p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--acc-primary);
            box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
        }

        .form-input.error {
            border-color: #dc2626;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--text-tertiary);
            pointer-events: none;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-tertiary);
            font-size: 20px;
            padding: 0;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--acc-primary);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #dc2626;
            margin-top: 6px;
        }

        .error-message i {
            font-size: 14px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--acc-primary) 0%, var(--acc-light-blue) 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            margin-top: 24px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .submit-btn i {
            font-size: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: white;
            opacity: 0.9;
        }

        .password-requirements {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }

        .password-requirements p {
            font-size: 11px;
            color: var(--text-tertiary);
            margin: 0 0 8px;
            font-weight: 600;
        }

        .password-requirements ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .password-requirements li {
            font-size: 11px;
            color: var(--text-secondary);
            padding: 4px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .password-requirements li i {
            font-size: 14px;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            .reset-card {
                padding: 32px 24px;
            }

            .logo-container h1 {
                font-size: 20px;
            }

            .logo-container img {
                width: 64px;
                height: 64px;
            }
        }

        .form-input:read-only {
            background-color: #f3f4f6;
            color: #6b7280;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="reset-card">
            <!-- Logo & Header -->
            <div class="logo-container">
                <img src="{{ asset('assets/logo.png') }}" alt="ACC Logo">
                <h1>Create New Password</h1>
                <p>Aklan Catholic College</p>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <i class='bx bx-shield-quarter'></i>
                <p>Please create a strong password for your account. Make sure it's at least 8 characters long.</p>
            </div>

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class='bx bx-envelope input-icon'></i>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                            class="form-input {{ $errors->get('email') ? 'error' : '' }}" placeholder="Enter your email"
                            required autofocus readonly>
                    </div>
                    @if ($errors->get('email'))
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif
                </div>


                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-wrapper">
                        <i class='bx bx-lock-alt input-icon'></i>
                        <input id="password" type="password" name="password"
                            class="form-input {{ $errors->get('password') ? 'error' : '' }}"
                            placeholder="Enter new password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <i class='bx bx-show' id="password-icon"></i>
                        </button>
                    </div>
                    @if ($errors->get('password'))
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $errors->first('password') }}</span>
                        </div>
                    @endif

                    <div class="password-requirements">
                        <p>Password must contain:</p>
                        <ul>
                            <li><i class='bx bx-check'></i> At least 8 characters</li>
                            <li><i class='bx bx-check'></i> Mix of letters and numbers</li>
                            <li><i class='bx bx-check'></i> At least one special character</li>
                        </ul>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <i class='bx bx-lock-alt input-icon'></i>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-input" placeholder="Confirm new password" required>
                        <button type="button" class="toggle-password"
                            onclick="togglePassword('password_confirmation')">
                            <i class='bx bx-show' id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <i class='bx bx-check-circle'></i>
                    Reset Password
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} Aklan Catholic College. All rights reserved.
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            }
        }
    </script>
</body>

</html>
