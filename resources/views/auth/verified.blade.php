<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verified - ACC</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeInScale 0.6s ease;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .success-icon i {
            font-size: 50px;
            color: white;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }

        p {
            font-size: 15px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 40px;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.4);
        }

        .countdown {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon">
            <i class='bx bx-check-circle'></i>
        </div>

        <h1>Email Verified!</h1>
        <p>Your email address has been successfully verified. You can now access all features of the ACC Scheduling
            System.</p>

        <a href="{{ route('dashboard') }}" class="btn" id="dashboardBtn">
            <i class='bx bx-home'></i>
            Go to Dashboard
        </a>

        <p class="countdown">Redirecting in <span id="countdown">5</span> seconds...</p>
    </div>

    <script>
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = "{{ route('dashboard') }}";
            }
        }, 1000);

        // Allow immediate navigation if user clicks button
        document.getElementById('dashboardBtn').addEventListener('click', function(e) {
            clearInterval(timer);
        });
    </script>
</body>

</html>
