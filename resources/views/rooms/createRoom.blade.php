<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/login.css" title="Document" />
    <title>Create room</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form class="form" action="{{ route('rooms.post') }}" method="post">
                @csrf
                <h1 class="title">Add New Room</h1>
                {{-- error handling --}}
                <div class="errors">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @error('email')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="column">
                    <div class="form-group mb-2">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Room Name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="role">Role Assigned:</label>
                        <select name="role_id" class="form-control" id="role_id" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="capacity">Capacity:</label>
                        <input type="number" name="capacity" class="form-control" required placeholder="Enter Capacity">
                    </div>

                    <div class="form-group mb-2">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
    @endsection
</body>

</html>
