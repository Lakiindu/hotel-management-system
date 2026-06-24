<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $emailTitle ?? 'RoyalStay Hotel' }}</title>
</head>

<body style="margin:0; padding:0; background:#e2e8f0; font-family:Arial, Helvetica, sans-serif;">

    <div style="width:100%; padding:40px 15px; box-sizing:border-box;">

        <div style="max-width:680px; margin:0 auto; background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 20px 45px rgba(15,23,42,0.18);">

            {{-- Top Accent --}}
            <div style="height:6px; background:linear-gradient(90deg,#f59e0b,#fbbf24,#fde68a);"></div>

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#020617,#0f172a,#1e293b); padding:34px 32px; color:#ffffff;">

                <div style="display:flex; align-items:center; gap:14px;">

                    <div style="width:52px; height:52px; border-radius:18px; background:#fbbf24; color:#020617; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:bold;">
                        R
                    </div>

                    <div>
                        <h1 style="margin:0; font-size:30px; line-height:1.2; letter-spacing:-0.5px;">
                            RoyalStay<span style="color:#fbbf24;">.</span>
                        </h1>

                        <p style="margin:6px 0 0; color:#cbd5e1; font-size:14px;">
                            Luxury Hotel & Resort Experience
                        </p>
                    </div>

                </div>

                <div style="margin-top:28px;">
                    <p style="margin:0 0 8px; color:#fbbf24; font-size:13px; font-weight:bold; text-transform:uppercase; letter-spacing:2px;">
                        {{ $emailSubtitle ?? 'Hotel Management System' }}
                    </p>

                    <h2 style="margin:0; font-size:26px; line-height:1.3; font-weight:800;">
                        {{ $emailTitle ?? 'RoyalStay Notification' }}
                    </h2>
                </div>

            </div>

            {{-- Main Content --}}
            <div style="padding:36px 32px; color:#334155; font-size:16px; line-height:1.7;">
                @yield('content')
            </div>

            {{-- Help Section --}}
            <div style="padding:0 32px 32px;">

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:18px; padding:20px;">

                    <h3 style="margin:0 0 10px; color:#020617; font-size:18px;">
                        Need Help?
                    </h3>

                    <p style="margin:0; color:#64748b; font-size:14px; line-height:1.7;">
                        If you have any questions, contact RoyalStay Hotel support.
                    </p>

                    <div style="margin-top:14px; font-size:14px; color:#334155;">
                        <p style="margin:5px 0;">
                            📍 Malabe, Sri Lanka
                        </p>

                        <p style="margin:5px 0;">
                            📞 +94 76 561 4545
                        </p>

                        <p style="margin:5px 0;">
                            ✉️ info@royalstay.com
                        </p>
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div style="background:#020617; padding:24px 32px; text-align:center;">

                <p style="margin:0 0 10px; color:#ffffff; font-size:16px; font-weight:bold;">
                    RoyalStay Hotel & Resort
                </p>

                <p style="margin:0; color:#94a3b8; font-size:13px; line-height:1.6;">
                    This is an automated email from RoyalStay Hotel Management System.
                    Please do not reply directly to this message.
                </p>

                <p style="margin:16px 0 0; color:#64748b; font-size:12px;">
                    © {{ date('Y') }} RoyalStay Hotel. All Rights Reserved.
                </p>

            </div>

        </div>

    </div>

</body>
</html>