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
            <form action="{{ route('updateUser', ['id' => $user->id]) }}" method="POST">
                <i class="fas fa-arrow-left rounded-circle border p-2"></i>
                <div class="form">
                    <h1>Edit User</h1>
                    <div class="errors">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
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

                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    @endsection
</body>

</html>
