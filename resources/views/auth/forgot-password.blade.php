{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Aklan Catholic College</title>
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
            --acc-gold: #f59e0b;
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

        .forgot-container {
            width: 100%;
            max-width: 440px;
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

        .forgot-card {
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
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
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
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .submit-btn i {
            font-size: 20px;
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 13px;
            color: var(--acc-primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .back-link:hover {
            color: var(--acc-light-blue);
        }

        .back-link i {
            font-size: 18px;
        }

        .success-message {
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #166534;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-message i {
            font-size: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: white;
            opacity: 0.9;
        }

        @media (max-width: 480px) {
            .forgot-card {
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
    </style>
</head>

<body>
    <div class="forgot-container">
        <div class="forgot-card">
            <!-- Logo & Header -->
            <div class="logo-container">
                <img src="{{ asset('assets/logo.png') }}" alt="ACC Logo">
                <h1>Reset Password</h1>
                <p>Aklan Catholic College</p>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <i class='bx bx-info-circle'></i>
                <p>Forgot your password? No problem. Just enter your email address and we'll send you a password reset
                    link that will allow you to choose a new one.</p>
            </div>

            <!-- Success Message -->
            @if (session('status'))
                <div class="success-message">
                    <i class='bx bx-check-circle'></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-input {{ $errors->get('email') ? 'error' : '' }}" placeholder="Enter your email"
                        required autofocus>
                    @if ($errors->get('email'))
                        <div class="error-message">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <i class='bx bx-envelope'></i>
                    Email Password Reset Link
                </button>

                <!-- Back to Login -->
                <a href="{{ route('login') }}" class="back-link">
                    <i class='bx bx-arrow-back'></i>
                    Back to Login
                </a>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            © {{ date('Y') }} Aklan Catholic College. All rights reserved.
        </div>
    </div>
</body>

</html>
