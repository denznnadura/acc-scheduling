<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 40px;
            text-align: center;
        }

        .header img {
            width: 80px;
            height: 80px;
            background: white;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            color: #dbeafe;
            margin: 8px 0 0;
            font-size: 14px;
        }

        .content {
            padding: 40px;
        }

        .content p {
            color: #4b5563;
            line-height: 1.6;
            margin: 0 0 16px;
        }

        .info-box {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 16px;
            border-radius: 4px;
            margin: 24px 0;
        }

        .info-box p {
            color: #1e40af;
            margin: 0;
            font-size: 13px;
        }

        .footer {
            background: #f9fafb;
            padding: 24px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            color: #6b7280;
            font-size: 12px;
            margin: 0;
        }
    </style>
</head>

<body>
    <table class="container" role="presentation">
        <tr>
            <td class="header">
                <img src="{{ asset('assets/logo.png') }}" alt="ACC Logo">
                <h1>Profile Updated</h1>
                <p>Aklan Catholic College</p>
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>Your profile information has been successfully updated in the ACC Scheduling System.</p>

                <div class="info-box">
                    <p><strong>Security Notice:</strong> If you did not make this change, please contact your
                        administrator immediately.</p>
                </div>

                <p>Updated details:</p>
                <ul style="color: #4b5563; line-height: 1.8;">
                    <li><strong>Name:</strong> {{ $user->name }}</li>
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                    <li><strong>Updated:</strong> {{ now()->format('M d, Y g:i A') }}</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>© {{ date('Y') }} Aklan Catholic College. All rights reserved.</p>
                <p style="margin-top: 8px; color: #9ca3af; font-size: 11px;">Kalibo, Aklan, Philippines</p>
            </td>
        </tr>
    </table>
</body>

</html>
