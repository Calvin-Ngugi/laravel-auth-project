<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/login.css" title="Document" />
    <title>Create patient</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form class="form" action="{{ route('patients.post') }}" method="post">
                @csrf
                <h1 class="title">Add New Patient</h1>
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
                        <div>
                            <label for="name">Name:</label>
                            <input type="name" name="name" class="form-control" id="Name" required
                                placeholder="Enter patient's name">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="id">Gender:</label>
                        <select class="form-control" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="id">Date of Birth:</label>
                        <input type="date" name="date" class="form-control" id="date" required
                            placeholder="Enter Date of Birth">
                    </div>
                    <div class="form-group d-flex mb-2">
                        <div class="me-3">
                            <label for="phone">Phone Number:</label>
                            <input type="phone" name="phone" class="form-control" id="phone" required
                                placeholder="0xxxxxxxxx">
                        </div>
                        <div class="me-3">
                            <label for="id">Id Number:</label>
                            <input type="id" name="idNumber" class="form-control" id="IdNumber" required
                                placeholder="Enter IdNumber">
                        </div>
                        <div>
                            <label for="name">Email:</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="form-group d-flex mb-2">
                        <div class="me-3">
                            <label for="next_of_kin_name">Next of Kin Name:</label>
                            <input type="name" name="nok_name" class="form-control" id="nok_name" required
                                placeholder="Enter next of kin's name">
                        </div>
                        <div class="me-3">
                            <label for="next_of_kin_phone">Next of Kin Phone:</label>
                            <input type="phone" name="nok_phone" class="form-control" id="nok_phone" required
                                placeholder="0xxxxxxxxx">
                        </div>
                        <div>
                            <label for="next_of_kin_relation">Next of Kin Relationship:</label>
                            <input type="text" name="nok_relation" class="form-control" id="nok_relation" required
                                placeholder="Enter next of kin's relationship">
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
    @endsection
</body>

</html>
