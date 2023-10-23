<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            margin-left: 15em;
            margin-right: 15em;
            background-color: whitesmoke;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1 style="color: rgb(6, 6, 6); text-align: center">Calvo's Org</h1>
        <div class="contain">
            <h1>OTP Verification Code</h1>
            <p>Your OTP code is: {{ $otp }}</p>
        </div>
    </div>
</body>

</html>
