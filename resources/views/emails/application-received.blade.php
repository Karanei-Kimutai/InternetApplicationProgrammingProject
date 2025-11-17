<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $applicationType }} Received</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f4f4f5;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            width: 100%;
            padding: 32px 0;
        }
        .card {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
        }
        h1 {
            margin-top: 0;
            color: #0f172a;
        }
        .chip {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }
        .details {
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 0;
            margin: 24px 0;
        }
        .details dt {
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .details dd {
            margin: 4px 0 16px;
            font-size: 15px;
            color: #111827;
        }
        .footer {
            margin-top: 24px;
            font-size: 13px;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="chip">We received your request</div>
        <h1>Hi {{ $recipientName }},</h1>
        <p>
            Thanks for submitting your {{ strtolower($applicationType) }}.
            Our security office has the details and will keep you posted by email as it moves through review.
        </p>

        <div class="details">
            <dl>
                <dt>Application Type</dt>
                <dd>{{ $applicationType }}</dd>
                <dt>Reason Selected</dt>
                <dd>{{ $reasonLabel }}</dd>
                <dt>Submitted</dt>
                <dd>{{ $submittedAt }}</dd>
            </dl>
        </div>

        <p>{{ $nextSteps }}</p>

        <p style="margin-top: 32px;">
            — {{ $senderName }}
        </p>

        <div class="footer">
            This confirmation was sent automatically. If you did not submit this request, contact
            the security office immediately.
        </div>
    </div>
</div>
</body>
</html>
