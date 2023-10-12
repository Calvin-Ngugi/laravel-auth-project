<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css" title="Login" />
    <title>Password change</title>
</head>

<body>
    <div class="align">
        <form class="form" action="{{ route('password.change.post') }}" method="post">
            @csrf
            <h1 class="title">Password Change form</h1>

            {{-- error handling --}}
            <div class="errors">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @error('password')
                    <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                @enderror

            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                    required>
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                    placeholder="Password">

            </div>
            <button class="btn btn-primary" type="submit">change password</button>
        </form>
    </div>
</body>

</html>
