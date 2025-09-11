<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <div class="email-header">
        <h2>{{ $subject }}</h2>
    </div>
    <div class="email-content">
        {!! nl2br(e($message)) !!}
    </div>
    <div class="email-footer"> 
        <p>This email was sent from Email Management System</p>
        <p>Sent to: {{ $recipientEmail }}</p>
    </div>
</body>
</html>