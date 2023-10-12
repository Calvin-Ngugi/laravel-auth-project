<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/email.css" title="Welcome">
    <title>Welcome Email</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h1>Welcome to Our Platform</h1>
            <div>
                <p>Dear {{ $emailData['username'] }},</p>
                <p>We are excited to welcome you to our platform. Thank you for joining us!</p>
                <p>Your account has been created successfully.</p>
                <p>Please feel free to explore our platform and <a class="link" href="http://127.0.0.1:8000"
                        class="btn btn-primary">get started</a>.</p>
                <p>Best regards,</p>
            </div>
            <p>Your Platform Team</p>
        </div>
    </div>
</body>

</html>
