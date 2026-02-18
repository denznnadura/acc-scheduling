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
                            style="background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%);padding:30px;text-align:center;">
                            <h1 style="color:#fff;margin:0;font-size:22px;">Verify Your Email</h1>
                            <p style="color:#dbeafe;margin:8px 0 0;font-size:13px;">Aklan Catholic College</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="color:#4b5563;margin:0 0 16px;font-size:14px;">Hello,</p>
                            <p style="color:#4b5563;margin:0 0 16px;font-size:14px;">Please verify your email address by
                                clicking the button below:</p>

                            <!-- Verify Button -->
                            <table role="presentation" style="margin:24px auto;">
                                <tr>
                                    <td
                                        style="background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%);padding:14px 32px;border-radius:8px;text-align:center;">
                                        <a href="{{ $url }}"
                                            style="color:#fff;text-decoration:none;font-size:15px;font-weight:600;">Verify
                                            Email Address</a>
                                    </td>
                                </tr>
                            </table>

                            <div style="background:#eff6ff;border-left:4px solid #3b82f6;padding:12px;margin:20px 0;">
                                <p style="color:#1e40af;margin:0;font-size:12px;">This verification link will expire in
                                    60 minutes.</p>
                            </div>

                            <p style="color:#6b7280;font-size:12px;margin:20px 0 0;">If you're having trouble, copy and
                                paste this URL:</p>
                            <p style="color:#3b82f6;font-size:11px;word-break:break-all;margin:4px 0;">
                                {{ $url }}</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;padding:20px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="color:#6b7280;font-size:11px;margin:0;">© {{ date('Y') }} Aklan Catholic
                                College</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
