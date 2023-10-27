<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../css/roles.css">
    <title>Document</title>
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

                <div class="form-group">
                    <label for="permissions">Permissions:</label>
                    @foreach ($permissions as $permission)
                        @if ($role->hasPermissionTo($permission))
                        @else
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    id="permission{{ $permission->id }}">
                                <label for="permission{{ $permission->id }}"
                                    class="form-check-label">{{ $permission->name }}</label>
                            </div>
                        @endif
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            <table class="table table-striped mt-3">
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
            </table>
        </div>
    @endsection
</body>

</html>
{{-- <h2>Edit role</h2>

    <form action="{{ route('admin.updateRole', $role->id) }}" method="post" class="w-75" style="display: flex; gap:5px;">
        @csrf
        <input type="hidden" name="id" value="{{ $role->id }}">
        <input type="text" name="name" class="form-control" value="{{ $role->name }}">
        <button class="btn btn-success" type="submit">update role name</button>
    </form>

    <h2>Role permissions</h2>
    <form action="{{ route('roles.addPermission', $role->id) }}" method="post" class="w-75"
        style="display: flex; gap:5px;">
        <input type="hidden" name="id" value="{{ $role->id }}">
        @csrf
        <select name="permission" class="form-select" @if (count($permissions) < 1) disabled @endif>
            @if (count($permissions) < 1)
                <option>No permissions</option>
            @else
                <option value="">...</option>
            @endif
            @foreach ($permissions as $permission)
                @if ($role->hasPermissionTo($permission))
                @else
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endif
            @endforeach
        </select>

        <button class="btn btn-success" type="submit">add permission</button>
    </form>
    <br>

    @if ($role->permissions)
        <table class="table table-striped table-bordered  w-75">
            <tr>
                <th scope="col" style="width:10px;"> No</th>
                <th scope="col" class="w-75">Permission</th>
                <th scope="col">Actions</th>
            </tr>
            @foreach ($role->permissions as $role_permission)
                <tr>
                    <th>
                        #{{ $loop->index + 1 }}
                    </th>
                    <td>
                        <p>{{ $role_permission->name }}</p>
                    </td>
                    <td>
                        @can('update role')
                            <form action="{{ route('roles.deletePermission') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $role->id }}">
                                <input type="hidden" name="permission" value="{{ $role_permission->name }}">
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h2>No permissions</h2>
    @endif --}}
