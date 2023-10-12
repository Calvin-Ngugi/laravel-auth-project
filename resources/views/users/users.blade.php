<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/users.css">
    <title>Document</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="contain">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h2>Users</h1>
                <a class="btn btn-success" href="{{ route('register') }}">Add New User</a>
            </div>
            @unless (count($users) == 0)
                @if (count($users) > 0)
                    @foreach ($users as $user)
                        <div class="card mt-1 mb-2">
                            <div class="card-body">
                                <div class="flex">
                                    <i class="fas fa-user rounded-circle border p-2"></i>
                                    <div>
                                        <h4 class="card-title">
                                            {{ $user['username'] }}
                                        </h4>
                                        <p class="card-text">
                                            {{ $user['email'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $users->links('pagination::bootstrap-4') }}
                @else
                    <h4>No users found
                        </h2>
                @endif
            @endunless
        </div>
    @endsection
</body>

</html>
