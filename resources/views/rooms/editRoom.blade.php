<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/login.css" title="Document" />
    <title>Edit room</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form class="form" action="{{ route('rooms.update', ['id' => $room->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <h1 class="title">Edit room</h1>
                {{-- error handling --}}
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
                    @error('email')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="column">
                    <div class="form-group mb-2">
                        <label for="height">Name:</label>
                        <input type="text" name="name" value="{{ $room->name }}" class="form-control"
                            placeholder="Enter Name" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="role">Role Assigned:</label>
                        <select name="role_id" id="role_id" class="form-control px-5">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $role->id == $room->role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="capacity">Capacity:</label>
                        <input type="number" name="capacity" value="{{ $room->capacity }}" class="form-control" required
                            placeholder="Enter capacity">
                    </div>

                    <div class="form-group mb-2">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" required>
                            @if ($room->status === 'available')
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            @else
                                <option value="unavailable">Unavailable</option>
                                <option value="available">Available</option>
                            @endif
                        </select>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
    @endsection
</body>

</html>
