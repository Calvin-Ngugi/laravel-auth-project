<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../css/roles.css">
    <title>HISP Edit role</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="contain">
            <h2>Edit Role</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.updateRole', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Role Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}">
                </div>

                <div class="form-group mt-3">
                    <label for="permissions">Permissions:</label>
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]"
                                value="{{ $permission->name }}"
                                id="permission{{ $permission->id }}"
                                {{ in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                            <label for="permission{{ $permission->id }}"
                                class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mb-3">Save Changes</button>
            </form>
            {{-- <table class="table table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">
                            Permissions
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($role->permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.removePermission') }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden" name="id" value="{{ $role->id }}">
                                    <input type="hidden" name="permission" value="{{ $permission->name }}">
                                    <button class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    @endsection
</body>

</html>