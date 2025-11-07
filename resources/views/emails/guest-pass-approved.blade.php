<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guest Pass Approved</title>
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #f0f9ff;
            color: #0f172a;
            margin: 0;
            padding: 32px 12px;
        }
        .card {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(14, 165, 233, 0.3);
        }
        h1 {
            margin-top: 0;
            font-size: 26px;
        }
        .meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin: 24px 0;
        }
        .meta div {
            background: #ecfeff;
            border-radius: 12px;
            padding: 12px 16px;
        }
        .meta span {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0ea5e9;
        }
        .meta strong {
            display: block;
            margin-top: 4px;
            font-size: 16px;
            color: #0f172a;
        }
        .cta a {
            display: inline-block;
            padding: 14px 32px;
            background: #0ea5e9;
            color: white;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
        }
        .footer {
            margin-top: 24px;
            font-size: 13px;
            color: #475569;
        }
    </style>
</head>
<body>
<div class="card">
    <p style="text-transform: uppercase; letter-spacing: 0.08em; color: #0ea5e9; margin-bottom: 12px;">Guest access confirmed</p>
    <h1>Your temporary pass is ready, {{ $recipientName }}.</h1>
    <p>
        Present the QR code attached to this email when you arrive on campus. Security can also scan the link below
        if you prefer to keep the pass on your phone.
    </p>

    <div class="meta">
        <div>
            <span>Purpose</span>
            <strong>{{ $reasonLabel }}</strong>
        </div>
        <div>
            <span>Valid From</span>
            <strong>{{ $validFrom }}</strong>
        </div>
        <div>
            <span>Valid Until</span>
            <strong>{{ $validUntil }}</strong>
        </div>
    </div>

    <div class="cta">
        <a href="{{ $qrShowUrl }}">Open QR Pass</a>
    </div>
    <p style="margin-top: 8px;">
        Officer link: <a href="{{ $qrVerifyUrl }}" style="color:#0ea5e9;">{{ $qrVerifyUrl }}</a>
    </p>

    <p class="footer">
        Save the attached PNG to your gallery so you can present it even if you are offline.
    </p>

    <p class="footer">
        — {{ $senderName }}
    </p>
</div>
</body>
</html>
