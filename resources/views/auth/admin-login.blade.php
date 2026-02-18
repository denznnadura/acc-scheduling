<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ACC</title>
    <style> body, html {

            margin: 0;

            padding: 0;

            height: 100%;

            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

            overflow: hidden; /* No scroll */

        }



        .bg-container {

            background: linear-gradient(135deg, #1e40af 0%, #0891b2 100%);

            height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

        }



        .login-card {

            background: white;

            width: 90%;

            max-width: 420px; /* Mas malapad ng kunti para sa laptop */

            padding: 30px 40px;

            border-radius: 20px;

            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);

            text-align: center;

        }



        .logo {

            height: 65px;

            margin-bottom: 10px;

        }



        h2 {

            margin: 0;

            font-size: 22px;

            font-weight: 800;

            color: #1f2937;

        }



        .role-admin { color: #dc2626; }

        .role-user { color: #2563eb; }



        .subtitle {

            font-size: 10px;

            color: #9ca3af;

            text-transform: uppercase;

            letter-spacing: 3px;

            margin-bottom: 25px;

            font-weight: bold;

        }



        .form-group {

            text-align: left;

            margin-bottom: 15px;

        }



        label {

            display: block;

            font-size: 11px;

            font-weight: bold;

            color: #4b5563;

            margin-bottom: 5px;

            text-transform: uppercase;

            padding-left: 5px;

        }



        input[type="email"], input[type="password"] {

            width: 100%;

            padding: 10px 15px;

            border: 1px solid #d1d5db;

            border-radius: 10px;

            box-sizing: border-box;

            font-size: 14px;

            outline: none;

            transition: border 0.3s;

        }



        input:focus {

            border-color: #2563eb;

        }



        .options {

            display: flex;

            justify-content: space-between;

            align-items: center;

            font-size: 11px;

            margin-bottom: 20px;

            color: #6b7280;

        }



        .btn-submit {

            width: 100%;

            padding: 12px;

            border: none;

            border-radius: 10px;

            color: white;

            font-weight: bold;

            text-transform: uppercase;

            letter-spacing: 1px;

            cursor: pointer;

            box-shadow: 0 4px 6px rgba(0,0,0,0.1);

            transition: 0.3s;

        }



        .btn-admin { background-color: #dc2626; }

        .btn-admin:hover { background-color: #b91c1c; }



        .btn-user { background-color: #2563eb; }

        .btn-user:hover { background-color: #1d4ed8; }



        .back-link {

            display: block;

            margin-top: 20px;

            font-size: 11px;

            color: #9ca3af;

            text-decoration: none;

            font-weight: bold;

        }



        .back-link:hover { color: #4b5563; }</style>
</head>
<body>
<div class="bg-container">
    <div class="login-card">
        <img src="{{ asset('assets/logo.png') }}" class="logo" alt="ACC Logo" onerror="this.src='https://via.placeholder.com/65?text=ACC'">
        
        <h2><span class="role-admin">🛡️ ADMIN PORTAL</span></h2>
        <div class="subtitle">Aklan Catholic College</div>

       <form method="POST" action="{{ route('admin.login.submit') }}">
    @csrf
    <div class="form-group">
        <label>Admin Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if($errors->has('email'))
            <span style="color:red; font-size:10px;">{{ $errors->first('email') }}</span>
        @endif
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="options">
        <label style="display: flex; align-items: center; cursor: pointer; text-transform: none;">
            <input type="checkbox" name="remember" style="margin-right: 5px;"> Remember me
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="color: #2563eb; text-decoration: none; font-style: italic;">Forgot Password?</a>
        @endif
    </div>

    <button type="submit" class="btn-submit btn-admin">Sign In as Admin</button>
    <a href="/" class="back-link">← BACK TO SELECTION</a>
</form>
    </div>
</div>
</body>
</html>