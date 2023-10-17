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
                    <table class="table table-striped mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">
                                    Username
                                </th>
                                <th scope="col">
                                    First Name
                                </th>
                                <th scope="col">
                                    Last Name
                                </th>
                                <th scope="col">
                                    Email
                                </th>
                                <th scope="col">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user['username'] }}</td>
                                    <td>{{ $user['first_name'] }}</td>
                                    <td>{{ $user['last_name'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle rounded-full" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                ...
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('editUser', ['id' => $user['id']]) }}">Edit</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                                <a class="dropdown-item" href="{{ route('users.index') }}">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
