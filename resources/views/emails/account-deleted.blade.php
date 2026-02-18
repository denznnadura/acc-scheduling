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
                    style="max-width:600px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#dc2626 0%,#ef4444 100%);padding:30px;text-align:center;">
                            <div
                                style="width:80px;height:80px;background:#fff;border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                                <span style="font-size:40px;color:#dc2626;">⚠️</span>
                            </div>
                            <h1 style="color:#fff;margin:0;font-size:22px;font-weight:700;">Account Deleted</h1>
                            <p style="color:#fecaca;margin:8px 0 0;font-size:13px;">Aklan Catholic College</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="color:#4b5563;margin:0 0 16px;font-size:14px;">Hello
                                <strong>{{ $userName }}</strong>,
                            </p>
                            <p style="color:#4b5563;margin:0 0 16px;font-size:14px;">This email confirms that your
                                account has been permanently deleted from the ACC Scheduling System.</p>

                            <!-- Info Box -->
                            <div
                                style="background:#fee2e2;border-left:4px solid #dc2626;padding:12px;margin:20px 0;border-radius:4px;">
                                <p style="color:#991b1b;margin:0;font-size:13px;line-height:1.6;"><strong>⚠️ Account
                                        Deletion Confirmed</strong><br>Your account and all associated data have been
                                    permanently removed from our system.</p>
                            </div>

                            <p style="color:#4b5563;margin:16px 0 8px;font-size:14px;"><strong>Deletion
                                    Details:</strong></p>
                            <table style="width:100%;margin:0 0 20px;">
                                <tr>
                                    <td style="padding:8px 0;font-size:13px;color:#6b7280;width:140px;">Account Name:
                                    </td>
                                    <td style="padding:8px 0;font-size:13px;color:#1f2937;">{{ $userName }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;font-size:13px;color:#6b7280;">Email Address:</td>
                                    <td style="padding:8px 0;font-size:13px;color:#1f2937;">{{ $userEmail }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;font-size:13px;color:#6b7280;">Deleted On:</td>
                                    <td style="padding:8px 0;font-size:13px;color:#1f2937;">
                                        {{ $deletedAt->format('M d, Y g:i A') }}</td>
                                </tr>
                            </table>

                            <p style="color:#4b5563;margin:16px 0 8px;font-size:13px;"><strong>What this means:</strong>
                            </p>
                            <ul style="color:#4b5563;font-size:12px;margin:0 0 20px;padding-left:20px;line-height:1.8;">
                                <li>Your account has been permanently deleted</li>
                                <li>All personal information has been removed</li>
                                <li>Your enrollments and schedules are no longer accessible</li>
                                <li>This action cannot be undone</li>
                            </ul>

                            <!-- Warning Box -->
                            <div
                                style="background:#fef3c7;border-left:4px solid #f59e0b;padding:12px;margin:20px 0;border-radius:4px;">
                                <p style="color:#92400e;margin:0;font-size:12px;line-height:1.6;"><strong>Did not
                                        request this?</strong><br>If you did not delete your account, someone may have
                                    accessed your account without authorization. Please contact the administrator
                                    immediately at <strong>admin@acc.edu.ph</strong>.</p>
                            </div>

                            <p style="color:#4b5563;margin:16px 0;font-size:13px;line-height:1.6;">If you change your
                                mind, you can create a new account, but your previous data cannot be recovered.</p>

                            <p style="color:#4b5563;margin:16px 0;font-size:13px;">Thank you for being part of Aklan
                                Catholic College.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;padding:20px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="color:#6b7280;font-size:11px;margin:0;line-height:1.5;"><strong>Aklan Catholic
                                    College</strong><br>Scheduling System</p>
                            <p style="color:#6b7280;font-size:11px;margin:8px 0 0;">© {{ date('Y') }} Aklan Catholic
                                College. All rights reserved.</p>
                            <p style="color:#9ca3af;font-size:10px;margin:4px 0 0;">Kalibo, Aklan, Philippines</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p style="text-align:center;color:#6b7280;font-size:11px;margin-top:20px;">
        This is an automated notification. Please do not reply to this email.<br>
        For support, contact: <span style="color:#3b82f6;">support@acc.edu.ph</span>
    </p>
</body>

</html>
