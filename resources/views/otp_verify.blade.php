<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css" title="Document" />
    <title>OTP Verification</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="#">Calvo's Org</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('listings') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Profile</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
    <div class="align ">
        {{-- error handling --}}
            <div class="errors">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            </div>
        <form action="{{ route('otp_verify.post') }}" class="form" method="post">
            @csrf
            <div class="form-group column">
                <h1>OTP Verification</h1>
                <label for="otp">Enter OTP sent to your email:</label>
                <input type="text" id="otp" name="otp" required placeholder="Enter OTP"
                    class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Verify OTP</button>
            </div>
        </form>
    </div>
</body>

</html>
