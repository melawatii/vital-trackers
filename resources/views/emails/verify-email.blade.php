<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Verify Email Address</title>
</head>
<body style="background:#f3f6fb;margin:0;padding:40px;font-family:Arial,Helvetica,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 6px 18px rgba(10,37,90,0.08);">
          <tr style="background:linear-gradient(90deg,#f0f6ff,#eef6ff);">
            <td style="padding:28px 40px;text-align:center;">
              @if (file_exists(public_path('build/assets/logo.png')))
                <img src="{{ $message->embed(public_path('build/assets/logo.png')) }}" alt="VitalTrackers" width="120" style="display:block;margin:0 auto 8px;">
              @elseif (file_exists(public_path('images/logo-email.png')))
                <img src="{{ $message->embed(public_path('images/logo-email.png')) }}" alt="VitalTrackers" width="120" style="display:block;margin:0 auto 8px;">
              @elseif (View::exists('components.application-logo'))
                <div style="text-align:center;margin:0 auto 8px;">
                  <x-application-logo width="120" style="display:block;margin:0 auto 8px;" />
                </div>
              @else
                <span style="font-weight:700;color:#0f172a;display:block;margin:0 auto 8px;">VitalTrackers</span>
              @endif
            </td>
          </tr>

          <tr>
            <td style="padding:36px 48px 24px;color:#0f172a;">
              <h1 style="margin:0 0 12px;font-size:22px;font-weight:700;">Hello{{ isset($user->name) ? ' '.$user->name : '' }}!</h1>
              <p style="margin:0 0 20px;color:#475569;line-height:1.5;">Please click the button below to verify your email address and activate your account.</p>

              <p style="text-align:center;margin:28px 0;">
                <a href="{{ $url }}" target="_blank" style="background:#1760ff;color:#fff;padding:14px 28px;border-radius:10px;display:inline-block;text-decoration:none;font-weight:600;">Verify Email Address</a>
              </p>

              <p style="margin:0 0 8px;color:#94a3b8;font-size:13px;">If you did not create an account, no further action is required.</p>

              <p style="margin:18px 0 0;color:#94a3b8;font-size:13px;">Regards,<br>Vital Trackers</p>
            </td>
          </tr>

          <tr>
            <td style="padding:18px 48px 28px;color:#9aa6b2;font-size:12px;border-top:1px solid #eef2f7;">
              <p style="margin:0 0 8px;word-break:break-all;">If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:</p>
              <p style="margin:0;color:#1773ff;word-break:break-all;font-size:12px;"><a href="{{ $url }}" style="color:#1773ff;">{{ $url }}</a></p>
            </td>
          </tr>

        </table>

        <p style="margin:18px 0 0;color:#94a3b8;font-size:12px;">© {{ date('Y') }} Vital Trackers. All rights reserved.</p>
      </td>
    </tr>
  </table>
</body>
</html>
