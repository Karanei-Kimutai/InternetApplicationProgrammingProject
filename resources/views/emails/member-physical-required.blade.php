<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visit Security Office</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #fef2f2;
            margin: 0;
            padding: 24px;
            color: #7f1d1d;
        }
        .panel {
            max-width: 640px;
            margin: 0 auto;
            background: #ffffff;
            border-left: 6px solid #dc2626;
            padding: 28px 32px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(185, 28, 28, 0.15);
        }
        h1 {
            margin-top: 0;
        }
        ul {
            padding-left: 20px;
        }
        .footer {
            margin-top: 24px;
            font-size: 13px;
            color: #991b1b;
        }
    </style>
</head>
<body>
<div class="panel">
    <h1>Hi {{ $recipientName }},</h1>
    <p>
        We noticed you've already requested a temporary pass for {{ strtolower($reasonLabel) }} in the last 30 days.
        For this reason we have to complete the process in person.
    </p>
    <p>Please carry the following to the security office:</p>
    <ul>
        <li>University ID (if available) or any government-issued identification</li>
        <li>A brief explanation of the situation for the duty officer</li>
        <li>This email on your phone for reference</li>
    </ul>
    <p>
        The security desk is open daily from 6:00 AM – 10:00 PM. They'll review your case on the spot and issue a pass.
    </p>
    <p class="footer">
        — {{ $senderName }}
    </p>
</div>
</body>
</html>
