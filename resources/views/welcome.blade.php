<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACC Portal - Selection</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden; /* Iwas scroll */
        }
        .wrapper {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 50%, #10b981 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: white;
            width: 100%;
            max-width: 600px; 
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            text-align: center;
        }
        .logo-img {
            height: 90px;
            margin-bottom: 20px;
        }
        h1 { font-size: 28px; margin: 0; color: #1f2937; }
        .tagline { font-size: 14px; color: #6b7280; margin-bottom: 40px; font-style: italic; }
        
        .grid {
            display: flex;
            gap: 20px;
        }
        .portal-link {
            flex: 1;
            text-decoration: none;
            padding: 30px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        /* Admin Button Styling */
        .admin-box { 
            border: 2px solid #ef4444; 
            color: #dc2626; 
        }
        .admin-box:hover { 
            background: #fef2f2; 
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.2);
        }
        
        /* User Button Styling */
        .user-box { 
            background: #2563eb; 
            color: white; 
        }
        .user-box:hover { 
            background: #1d4ed8; 
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .icon { font-size: 50px; margin-bottom: 10px; }
        .btn-title { font-weight: bold; font-size: 20px; }
        .btn-sub { font-size: 10px; text-transform: uppercase; margin-top: 5px; opacity: 0.8; }
        
        .footer { margin-top: 40px; font-size: 10px; color: #9ca3af; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <img src="{{ asset('assets/logo.png') }}" class="logo-img" alt="ACC Logo" onerror="this.src='https://via.placeholder.com/90?text=ACC'">
            
            <h1>Aklan Catholic College</h1>
            <p class="tagline">"Pro Deo et Patria" - Class Scheduling System Portal</p>

            <div class="grid">
                <a href="{{ route('admin.login') }}" class="portal-link admin-box">
                    <span class="icon">🛡️</span>
                    <span class="btn-title">Admin Portal</span>
                    <span class="btn-sub">Authorized Only</span>
                </a>

                <a href="{{ route('login') }}" class="portal-link user-box">
                    <span class="icon">🎓</span>
                    <span class="btn-title">Student/Faculty</span>
                    <span class="btn-sub" style="color: #bfdbfe;">Schedules & Profile</span>
                </a>
            </div>

            <div class="footer">
                &copy; {{ date('Y') }} AKLAN CATHOLIC COLLEGE - KALIBO, AKLAN
            </div>
        </div>
    </div>
</body>
</html>