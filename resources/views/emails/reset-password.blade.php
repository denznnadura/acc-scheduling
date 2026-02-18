<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f3f4f6;">
        <tr>
            <td style="padding: 40px 20px;">
                <!-- Main Container -->
                <table role="presentation"
                    style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">

                    <!-- Header with Logo -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 40px; text-align: center; border-radius: 12px 12px 0 0;">
                            <img src="{{ asset('assets/logo.png') }}" alt="ACC Logo"
                                style="width: 80px; height: 80px; margin-bottom: 16px; background: white; padding: 10px; border-radius: 12px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700;">Password Reset
                                Request</h1>
                            <p style="color: #dbeafe; margin: 8px 0 0; font-size: 14px;">Aklan Catholic College</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 40px 20px;">
                            <p style="color: #1f2937; font-size: 16px; line-height: 1.6; margin: 0 0 20px;">
                                Hello <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 24px;">
                                You are receiving this email because we received a password reset request for your
                                account.
                                Click the button below to reset your password:
                            </p>

                            <!-- Reset Button -->
                            <table role="presentation" style="margin: 0 auto;">
                                <tr>
                                    <td
                                        style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 16px 32px; border-radius: 8px; text-align: center;">
                                        <a href="{{ $url }}"
                                            style="color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; display: inline-block;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 32px 0 24px;">
                                This password reset link will expire in <strong>60 minutes</strong>.
                            </p>

                            <p style="color: #6b7280; font-size: 14px; line-height: 1.6; margin: 0 0 16px;">
                                If you did not request a password reset, no further action is required. Your account
                                remains secure.
                            </p>

                            <!-- Info Box -->
                            <div
                                style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 4px; margin: 24px 0;">
                                <p style="color: #1e40af; font-size: 13px; margin: 0; line-height: 1.5;">
                                    <strong>Security Tip:</strong> If you didn't request this reset, please contact your
                                    administrator immediately.
                                </p>
                            </div>

                            <!-- Alternative Link -->
                            <p
                                style="color: #6b7280; font-size: 12px; line-height: 1.5; margin: 24px 0 0; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                                If you're having trouble clicking the button, copy and paste the URL below into your web
                                browser:
                            </p>
                            <p
                                style="color: #3b82f6; font-size: 11px; line-height: 1.5; margin: 8px 0 0; word-break: break-all;">
                                <a href="{{ $url }}" style="color: #3b82f6;">{{ $url }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background: #f9fafb; padding: 24px 40px; border-radius: 0 0 12px 12px; border-top: 1px solid #e5e7eb;">
                            <p
                                style="color: #6b7280; font-size: 12px; text-align: center; margin: 0; line-height: 1.5;">
                                © {{ date('Y') }} Aklan Catholic College. All rights reserved.
                            </p>
                            <p style="color: #9ca3af; font-size: 11px; text-align: center; margin: 8px 0 0;">
                                Kalibo, Aklan, Philippines
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Footer Text -->
                <p style="color: #6b7280; font-size: 11px; text-align: center; margin: 24px 0 0;">
                    This is an automated message. Please do not reply to this email.
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
