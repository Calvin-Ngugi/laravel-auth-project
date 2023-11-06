<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Roles</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="mt-2">
            <h2>Create Role</h2>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form class="form" action="{{ route('admin.createRole') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="permissions">Permissions:</label>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                id="permission{{ $permission->id }}">
                            <label for="permission{{ $permission->id }}"
                                class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </form>
        </div>
    @endsection
</body>

</html>
