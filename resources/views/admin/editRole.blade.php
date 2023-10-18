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

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    @endsection
</body>

</html>
