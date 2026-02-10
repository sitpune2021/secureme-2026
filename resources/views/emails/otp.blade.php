<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
</head>

<body style="font-family: Arial, sans-serif;">
    <h2>Login Verification</h2>

    <p>Your One-Time Password (OTP) is:</p>

    <h1 style="letter-spacing: 5px;">{{ $otp }}</h1>

    <p>This OTP will expire in <strong>5 minutes</strong>.</p>

    <p>If you didn’t request this, please ignore this email.</p>

    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
