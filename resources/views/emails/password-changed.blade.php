<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f3f4f6;">
    <table role="presentation" style="width:100%;border-collapse:collapse;">
        <tr>
            <td style="padding:20px;">
                <table role="presentation"
                    style="max-width:600px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#059669 0%,#10b981 100%);padding:30px;text-align:center;">
                            <h1 style="color:#fff;margin:0;font-size:22px;">Password Changed</h1>
                            <p style="color:#d1fae5;margin:8px 0 0;font-size:13px;">Aklan Catholic College</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="color:#4b5563;margin:0 0 16px;font-size:14px;">Hello
                                <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="color:#4b5563;margin:0 0 16px;font-size:14px;">Your password has been successfully
                                changed.</p>

                            <!-- Success Box -->
                            <div style="background:#f0fdf4;border-left:4px solid #10b981;padding:12px;margin:20px 0;">
                                <p style="color:#065f46;margin:0;font-size:13px;"><strong>✓ Password
                                        Updated</strong><br>You can now use your new password to log in.</p>
                            </div>

                            <p style="color:#4b5563;margin:16px 0 8px;font-size:14px;"><strong>Change Details:</strong>
                            </p>
                            <table style="width:100%;margin:0 0 20px;">
                                <tr>
                                    <td style="padding:8px 0;font-size:13px;color:#6b7280;">Account:</td>
                                    <td style="padding:8px 0;font-size:13px;color:#1f2937;">{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;font-size:13px;color:#6b7280;">Email:</td>
                                    <td style="padding:8px 0;font-size:13px;color:#1f2937;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;font-size:13px;color:#6b7280;">Date:</td>
                                    <td style="padding:8px 0;font-size:13px;color:#1f2937;">
                                        {{ now()->format('M d, Y g:i A') }}</td>
                                </tr>
                            </table>

                            <!-- Warning Box -->
                            <div style="background:#fef3c7;border-left:4px solid #f59e0b;padding:12px;margin:20px 0;">
                                <p style="color:#92400e;margin:0;font-size:12px;"><strong>⚠️ Security
                                        Alert</strong><br>If you didn't make this change, contact your administrator
                                    immediately.</p>
                            </div>

                            <p style="color:#4b5563;margin:16px 0 8px;font-size:13px;"><strong>Security Tips:</strong>
                            </p>
                            <ul style="color:#4b5563;font-size:12px;margin:0;padding-left:20px;">
                                <li>Never share your password</li>
                                <li>Use unique passwords</li>
                                <li>Log out from public computers</li>
                            </ul>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;padding:20px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="color:#6b7280;font-size:11px;margin:0;">© {{ date('Y') }} Aklan Catholic
                                College</p>
                            <p style="color:#9ca3af;font-size:10px;margin:4px 0 0;">Kalibo, Aklan, Philippines</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
