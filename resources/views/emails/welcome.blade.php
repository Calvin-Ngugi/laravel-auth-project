<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: bisque;
        }

        .container {
            border: 1px solid;
            border-radius: 10px;
            padding: 10px;
            margin: 10px;
            background-image: url("https://images.unsplash.com/photo-1618005198919-d3d4b5a92ead?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }


        .contain {
            border: 1px solid;
            border-radius: 5px;
            padding: 10px;
            margin-top: 80px;
            margin-bottom: 70px;
            margin-left: 20em;
            margin-right: 20em;
            background-color: whitesmoke;
        }

        a {
            color: rgb(77, 233, 236);
            text-decoration: none;
        }
        a :hover{
            cursor: pointer;
            text-decoration: underline;
        } 
    </style>
    <title>Welcome Email</title>
</head>

<body>
    <div class="container">
        <div class="contain">
            <h1>Welcome to Our Platform</h1>
            <br/>
            <div>
                <p>Dear {{ $emailData['username'] }},</p>
                <p>We are excited to welcome you to our platform. Thank you for joining us!</p>
                <p>Your account has been created successfully.</p>
                <p>Please feel free to explore our platform and <a class="link" href="http://127.0.0.1:8000"
                        class="btn btn-primary">get started</a>.</p>
                <p>Best regards,</p>
            </div>
            <p>The Platform Team</p>
        </div>
    </div>
</body>

</html>
