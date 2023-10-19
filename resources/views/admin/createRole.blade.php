<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/users.css" title="roles">
    <title>Create Roles</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="contain mr-2 pt-3">
            <h2>Create Role</h2>
            <form class="form" action="{{ route('admin.createRole') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="permissions">Permissions:</label>
                    <select name="permissions[]" id="permissions" class="form-control" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </form>
        </div>
    @endsection
</body>

</html>
