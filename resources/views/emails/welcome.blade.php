<!DOCTYPE html>
<html>

<head>
    <title>Welcome Email</title>
</head>

<body>
    <h2>Welcome to Our Website!</h2>
    <p>
        Thank you for registering. Your account details are as follows:
    </p>
    <p>
        Username: {{ $emailData['username'] }}
        <br>
        Password: Password
    </p>
    <p>
        Please keep your credentials secure and don't share them with others.
    </p>
</body>

</html>
