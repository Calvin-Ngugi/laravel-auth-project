<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/login.css" title="Document" />
    <title>Create Medicine</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form class="form" action="{{ route('medicine.update', ['id' => $medicine['id']]) }}" method="post">
                @csrf
                @method('put')
                <h1 class="title">Edit Medicine</h1>
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
                    @error('name')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('unit_cost')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('no_in_inventory')
                        <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="column">
                    <div class="form-group mb-2">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" value={{ $medicine->name }} id="name"
                            required placeholder="Enter medicine's name">
                    </div>
                    <div class="form-group mb-2">
                        <label for="cost">Unit cost:</label>
                        <input type="text" name="unit_cost" class="form-control" value={{ $medicine->unit_cost }}
                            id="unit_cost" required placeholder="Enter Unit Cost">
                    </div>
                    <div class="form-group mb-2">
                        <label for="status">Number in Inventory:</label>
                        <input type="text" name="no_in_inventory" class="form-control"
                            value={{ $medicine->no_in_inventory }} id="unit_cost" required
                            placeholder="Enter Number in Inventory">
                    </div>
                    <div class="form-group mb-2">
                        <label for="name">Type:</label>
                        <input type="text" name="type" class="form-control" value={{ $medicine->type }} id="type"
                            required placeholder="Enter medicine type">
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
    @endsection
</body>

</html>
