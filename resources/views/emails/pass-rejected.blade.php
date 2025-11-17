<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Temporary Pass Update</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fff7ed;
            margin: 0;
            padding: 24px;
            color: #7c2d12;
        }
        .panel {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-left: 6px solid #f97316;
            border-radius: 12px;
            padding: 28px 32px;
            box-shadow: 0 18px 40px rgba(249, 115, 22, 0.15);
        }
        h1 {
            margin-top: 0;
            color: #7c2d12;
        }
        .footer {
            margin-top: 24px;
            font-size: 13px;
            color: #9a3412;
        }
    </style>
</head>
<body>
<div class="panel">
    <h1>Hi {{ $recipientName }},</h1>
    <p>
        We reviewed your temporary pass request for <strong>{{ $reasonLabel }}</strong>, but we’re unable to approve it at this time.
    </p>
    <p>
        If you still need access, please visit the security office with valid identification so that we can complete the process in person.
    </p>
    <p class="footer">
        — {{ $senderName }}
    </p>
</div>
</body>
</html>
