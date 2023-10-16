<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/roles.css" title="roles">
    <title>Roles</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="contain mr-3 pt-3">
            <h2 class="mb-3">Roles and Permissions</h2>
            @foreach ($roles as $role)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>
                            Role: {{ $role->name }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Permissions:</h5>
                        <ul>
                            @foreach ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>

                        <h5 class="card-title">Users:</h5>
                        <ul>
                            @foreach ($role->users as $user)
                                <li>{{ $user->username }}</li>
                            @endforeach
                        </ul>

                        <form action="{{ route('admin.assignRole.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                            <label for="user_id">Assign Role to User:</label>
                            <select name="user_id" id="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">Assign Role</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
</body>

</html>
