<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login - ACC</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .bg-container {
            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 420px; 
            padding: clamp(25px, 5vw, 40px);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            text-align: center;
            box-sizing: border-box;
        }

        .logo {
            height: clamp(50px, 10vw, 65px);
            margin-bottom: 12px;
        }

        h2 {
            margin: 0;
            font-size: clamp(18px, 4vw, 22px);
            font-weight: 800;
            color: #1f2937;
        }

        .role-user { color: #2563eb; }

        .subtitle {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #4b5563;
            margin-bottom: 6px;
            text-transform: uppercase;
            padding-left: 2px;
        }

        /* Password Wrapper for the Icon */
        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        input#password {
            padding-right: 45px; /* Space for the lash icon */
        }

        input:focus {
            border-color: #2563eb;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .options {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            margin-bottom: 25px;
            color: #6b7280;
            gap: 10px;
        }

        @media (max-width: 350px) {
            .options {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
            background-color: #2563eb;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.4);
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            font-size: 11px;
            color: #9ca3af;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }

        .back-link:hover { color: #4b5563; }

        .error-msg {
            color: #ef4444;
            font-size: 11px;
            margin-top: 5px;
            display: block;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="bg-container">
    <div class="login-card">
        <img src="{{ asset('assets/logo.png') }}" class="logo" alt="ACC Logo" onerror="this.src='https://via.placeholder.com/65?text=ACC'">
        
        <h2><span class="role-user">🎓 STUDENT/FACULTY</span></h2>
        <div class="subtitle">Aklan Catholic College</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="username@email.com" required autofocus>
                @if($errors->has('email'))
                    <span class="error-msg">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                    <button type="button" class="toggle-password" id="toggleBtn">
                        <svg id="lashIcon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="options">
                <label style="display: flex; align-items: center; cursor: pointer; text-transform: none; font-weight: 500;">
                    <input type="checkbox" name="remember" style="margin-right: 8px; width: 16px; height: 16px; cursor: pointer;"> Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: #2563eb; text-decoration: none; font-weight: 600;">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">Sign In to Portal</button>
            <a href="/" class="back-link">← BACK TO SELECTION</a>
        </form>
    </div>
</div>

<script>
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('toggleBtn');
    const lashIcon = document.getElementById('lashIcon');

    // SVG designs for the lashes style
    const hiddenSVG = `
        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"></path>
        <line x1="1" y1="1" x2="23" y2="23"></line>
    `;

    const visibleSVG = `
        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
        <circle cx="12" cy="12" r="3"></circle>
        <line x1="3" y1="5" x2="5" y2="8"></line>
        <line x1="21" y1="5" x2="19" y2="8"></line>
        <line x1="12" y1="2" x2="12" y2="4"></line>
    `;

    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        lashIcon.innerHTML = isPassword ? visibleSVG : hiddenSVG;
    });
</script>
</body>
</html>