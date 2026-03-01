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
            min-height: 100vh;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            /* Inalis ang overflow: hidden para makapag-scroll sa maliliit na phone kung kailangan */
        }
        
        .wrapper {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 50%, #10b981 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .card {
            background: white;
            width: 100%;
            max-width: 650px; 
            padding: 30px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            text-align: center;
            box-sizing: border-box;
        }

        .logo-img {
            height: clamp(60px, 10vw, 90px); /* Responsive height */
            margin-bottom: 15px;
        }

        h1 { 
            font-size: clamp(20px, 5vw, 28px); 
            margin: 0; 
            color: #1f2937; 
            font-weight: 800;
        }

        .tagline { 
            font-size: clamp(12px, 3vw, 14px); 
            color: #6b7280; 
            margin-bottom: 30px; 
            font-style: italic; 
            line-height: 1.4;
        }
        
        /* RESPONSIVE GRID */
        .grid {
            display: flex;
            flex-direction: column; /* Default: Stacked sa mobile */
            gap: 15px;
        }

        /* Desktop View (768px pataas) */
        @media (min-width: 480px) {
            .grid {
                flex-direction: row; /* Tabi-tabi na sa tablet/desktop */
            }
            .card {
                padding: 50px;
            }
        }

        .portal-link {
            flex: 1;
            text-decoration: none;
            padding: 25px 15px;
            border-radius: 18px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .admin-box { 
            border: 2px solid #ef4444; 
            color: #dc2626; 
        }
        
        .admin-box:hover { 
            background: #fef2f2; 
            transform: translateY(-8px);
            box-shadow: 0 12px 20px -5px rgba(239, 68, 68, 0.25);
        }
        
        .user-box { 
            background: #2563eb; 
            color: white; 
        }
        
        .user-box:hover { 
            background: #1d4ed8; 
            transform: translateY(-8px);
            box-shadow: 0 12px 20px -5px rgba(37, 99, 235, 0.35);
        }

        .icon { 
            font-size: 40px; 
            margin-bottom: 12px; 
        }
        
        .btn-title { font-weight: bold; font-size: 18px; }
        .btn-sub { font-size: 10px; text-transform: uppercase; margin-top: 6px; opacity: 0.8; letter-spacing: 0.5px; }
        
        .footer { 
            margin-top: 35px; 
            font-size: 10px; 
            color: #9ca3af; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 1.2px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <img src="{{ asset('assets/logo.png') }}" class="logo-img" alt="ACC Logo" onerror="this.src='https://via.placeholder.com/90?text=ACC'">
            
            <h1>Aklan Catholic College</h1>
            <p class="tagline">"Pro Deo et Patria" <br> Class Scheduling System Portal</p>

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
                &copy; {{ date('Y') }} AKLAN CATHOLIC COLLEGE <br> KALIBO, AKLAN, PHILIPPINES
            </div>
        </div>
    </div>
</body>
</html>