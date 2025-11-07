<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Temporary Pass Is Ready</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #0f172a;
            margin: 0;
            padding: 24px;
            color: #e2e8f0;
        }
        .ticket {
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            border-radius: 24px;
            padding: 32px;
            max-width: 720px;
            margin: 0 auto;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.45);
        }
        h1 {
            margin-top: 0;
            font-size: 28px;
        }
        .meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin: 24px 0;
        }
        .meta div {
            background: rgba(15, 23, 42, 0.2);
            border-radius: 12px;
            padding: 12px 16px;
        }
        .meta span {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(226, 232, 240, 0.75);
        }
        .meta strong {
            display: block;
            font-size: 16px;
            margin-top: 4px;
        }
        .cta {
            margin: 32px 0 16px;
        }
        .cta a {
            background: #fbbf24;
            color: #0f172a;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 999px;
            font-weight: 600;
            display: inline-block;
        }
        .footer {
            margin-top: 24px;
            font-size: 13px;
            color: rgba(226, 232, 240, 0.8);
        }
        .qr-note {
            margin-top: 16px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="ticket">
    <h1>Your temporary pass is ready, {{ $recipientName }}!</h1>
    <p>
        Present the QR code attached to this email when entering campus.
        We've also linked it below so you can pull it up quickly from any device.
    </p>

    <div class="meta">
        <div>
            <span>Reason</span>
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
        <div>
            <span>Reference</span>
            <strong>{{ $passReference }}</strong>
        </div>
    </div>

    <div class="cta">
        <a href="{{ $qrShowUrl }}">View QR Pass</a>
    </div>
    <div class="qr-note">
        Backup link for security officers: <a href="{{ $qrVerifyUrl }}" style="color:#fef3c7;">{{ $qrVerifyUrl }}</a>
    </div>

    <p class="footer">
        Tip: save the attached PNG to your wallet or gallery in advance. The QR token is unique to you and
        will expire automatically once the pass validity window ends.
    </p>

    <p class="footer">
        — {{ $senderName }}
    </p>
</div>
</body>
</html>
