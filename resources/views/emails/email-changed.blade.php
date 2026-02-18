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
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
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
            color: #fecaca;
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

        .warning-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            border-radius: 4px;
            margin: 24px 0;
        }

        .warning-box p {
            color: #92400e;
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
                <h1>Email Address Changed</h1>
                <p>Aklan Catholic College</p>
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Hello <strong>{{ $user->name }}</strong>,</p>
                <p>This is to inform you that your email address has been changed in the ACC Scheduling System.</p>

                <div class="warning-box">
                    <p><strong>⚠️ Security Alert:</strong> Your email has been changed from this address to
                        <strong>{{ $newEmail }}</strong>. If you did not make this change, please contact your
                        administrator immediately!
                    </p>
                </div>

                <p><strong>What happens next?</strong></p>
                <ul style="color: #4b5563; line-height: 1.8;">
                    <li>Your new email address will need to be verified</li>
                    <li>Future notifications will be sent to the new address</li>
                    <li>This old email address is no longer associated with your account</li>
                </ul>

                <p>Change Details:</p>
                <ul style="color: #4b5563; line-height: 1.8;">
                    <li><strong>Previous Email:</strong> {{ $user->email }}</li>
                    <li><strong>New Email:</strong> {{ $newEmail }}</li>
                    <li><strong>Changed On:</strong> {{ now()->format('M d, Y g:i A') }}</li>
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
