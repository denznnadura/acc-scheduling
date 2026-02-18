<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - ACC</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #059669 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
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

        .verify-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .verify-icon i {
            font-size: 40px;
            color: white;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        p {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .info-box {
            background: #eff6ff;
            border: 2px solid #93c5fd;
            border-radius: 10px;
            padding: 16px;
            margin: 24px 0;
            text-align: left;
        }

        .info-box p {
            color: #1e40af;
            font-size: 13px;
            margin: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .btn i {
            font-size: 20px;
        }

        .resend-form {
            margin-top: 16px;
        }

        .success-box {
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-radius: 10px;
            padding: 16px;
            margin: 20px 0;
        }

        .success-box p {
            color: #166534;
            margin: 0;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="verify-container">
        <div class="verify-icon">
            <i class='bx bx-envelope'></i>
        </div>

        <h1>Verify Your Email</h1>
        <p>Thanks for signing up! Please verify your email address to continue.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="success-box">
                <p><i class='bx bx-check-circle'></i> A new verification link has been sent to your email address!</p>
            </div>
        @endif

        <div class="info-box">
            <p><strong>Check your email</strong><br>
                We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>. Click the link in the
                email to verify your account.</p>
        </div>

        <form method="POST" action="{{ route('verification.send') }}" class="resend-form">
            @csrf
            <button type="submit" class="btn">
                <i class='bx bx-refresh'></i>
                Resend Verification Email
            </button>
        </form>

        <p style="margin-top: 24px; font-size: 12px;">
            <a href="{{ route('profile.edit') }}" style="color: #3b82f6; text-decoration: none;">Back to Profile</a>
            |
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit"
                style="background: none; border: none; color: #3b82f6; cursor: pointer; padding: 0; font-size: 12px;">Logout</button>
        </form>
        </p>
    </div>
</body>

</html>
