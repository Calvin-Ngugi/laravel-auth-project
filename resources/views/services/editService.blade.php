<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/login.css" title="Document" />
    <title>Create Service</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form class="form" action="{{ route('services.update', ['id' => $service['id']]) }}" method="post">
                @csrf
                @method('PUT')
                <h1 class="title">Add New Service</h1>
                {{-- error handling --}}
                <div class="errors">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @error('name')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('unit_cost')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('status')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="column">
                    <div class="form-group mb-2">
                        <div>
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" value={{$service->name}} id="name" required
                                placeholder="Enter services's name">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="cost">Unit cost:</label>
                        <input type="text" name="unit_cost" class="form-control" value={{$service->unit_cost}} id="unit_cost" required
                            placeholder="Enter Unit Cost">
                    </div>
                    <div class="form-group mb-2">
                        <label for="status">Status:</label>
                        <select class="form-control" name="status" required>
                            @if ($service->status === 'available')
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
