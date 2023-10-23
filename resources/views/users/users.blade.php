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
                        <thead class="thead-dark table-dark">
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
                                    Status  
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
                                    <td>{{ $user['status'] }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                                role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item"
                                                    href="{{ route('editUser', ['id' => $user['id']]) }}">Edit</a>
                                                <a class="dropdown-item" href="{{ route('users.index') }}">View</a>
                                                <a class="dropdown-item" href="{{ route('users.index') }}"
                                                    onclick="confirmDelete({{ $user['id'] }})">Delete</a>
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
<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            // If user confirms, send a DELETE request
            fetch(`/users/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page or update the UI as needed
                        window.location.reload();
                    } else {
                        alert('Failed to delete the user.');
                    }
                });
        }
    }
</script>

</html>
