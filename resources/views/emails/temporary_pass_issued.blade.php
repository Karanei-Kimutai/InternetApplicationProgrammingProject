<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Pass Approved</title>
</head>
<body style="font-family: -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; color:#111827;">
    <div style="max-width:600px;margin:0 auto;padding:24px;">
        <h1 style="font-size:20px;margin:0 0 8px;">Temporary Pass Approved</h1>
        <p style="margin:0 0 12px;">Hello {{ $recipientName }},</p>
        <p style="margin:0 0 12px;">Your temporary pass has been issued.</p>

        @if ($pass->valid_from || $pass->valid_until)
            <p style="margin:0 0 12px;color:#374151;font-size:14px;">
                @if ($pass->valid_from)
                    <strong>Valid from:</strong> {{ optional($pass->valid_from)->toDayDateTimeString() }}<br>
                @endif
                @if ($pass->valid_until)
                    <strong>Valid until:</strong> {{ optional($pass->valid_until)->toDayDateTimeString() }}
                @endif
            </p>
        @endif

        <p style="margin:16px 0 12px;">
            You can present the attached QR code at the gate, or open it here:
        </p>
        <p style="margin:0 0 16px;">
            <a href="{{ $qrUrl }}" style="background:#2563eb;color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">View QR Code</a>
            <a href="{{ $verifyUrl }}" style="margin-left:8px;background:#f3f4f6;color:#111827;padding:10px 14px;border-radius:8px;text-decoration:none;">Verify JSON</a>
        </p>

        <p style="margin:16px 0 0;color:#6b7280;font-size:12px;">
            Lost ID passes last 7 days; all other passes last 1 day. Lost/Misplaced ID requests are limited to one every 30 days.
        </p>
    </div>
</body>
</html>

