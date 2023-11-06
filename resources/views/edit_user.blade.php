<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../../css/edit.css" />
    <title>Edit User</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form action="{{ route('updateUser', ['id' => $user->id]) }}" method="post">
                <div class="form">
                    <h1>Edit User</h1>
                    <div class="errors">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @else
                        @endif
                    </div>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="name" name="username" value="{{ $user->username }}" required
                            placeholder="Enter Username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fname">First Name:</label>
                        <input type="name" name="first_name" value="{{ $user->first_name }}" required
                            placeholder="Enter First Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name:</label>
                        <input type="name" name="last_name" value="{{ $user->last_name }}" required
                            placeholder="Enter Last Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select name="role" id="role" class="form-control px-5">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    @endsection
</body>

</html>
