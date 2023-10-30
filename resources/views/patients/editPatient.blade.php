<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/login.css" title="Document" />
    <title>Create patient</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer>
        // Attach an input event listener to the phone number input field
        $('#phone').on('input', function() {
            // Remove any non-numeric characters (except '+')
            var phoneNumber = $(this).val().replace(/[^0-9+]/g, '');

            if (!phoneNumber.startsWith('254')) {
                phoneNumber = '+254' + phoneNumber;
            }

            // Update the input field value
            $(this).val(phoneNumber);
        });
    </script>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="align">
            <form class="form" action="{{ route('patients.update', ['id' => $patient['id']]) }}" method="POST">
                @csrf
                @method('PUT')
                <h1 class="title">Edit Patient</h1>
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
                        <div>
                            <label for="name">Name:</label>
                            <input type="name" name="name" class="form-control" id="Name" required
                                placeholder="Enter patient's name" value="{{ $patient->name }}">
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="id">Gender:</label>
                        <select class="form-control" name="gender" required>
                            @if ($patient->gender === 'male')
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            @else
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="id">Date of Birth:</label>
                        <input type="date" name="date" class="form-control" id="date" required
                            placeholder="Enter Date of Birth" value="{{ $patient->dob }}">
                    </div>
                    <div class="form-group d-flex mb-2">
                        <div class="me-3">
                            <label for="phone">Phone Number:</label>
                            <input type="phone" name="phone" class="form-control" id="phone" required
                                placeholder="Enter phone number" value="{{ $patient->phone_number }}">
                        </div>
                        <div class="me-3">
                            <label for="id">Id Number:</label>
                            <input type="id" name="idNumber" class="form-control" id="IdNumber" required
                                placeholder="Enter IdNumber" value="{{ $patient->id_number }}">
                        </div>
                        <div>
                            <label for="name">Email:</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Enter email" value="{{ $patient->email }}">
                        </div>
                    </div>
                    <div class="form-group d-flex mb-2">
                        <div class="me-3">
                            <label for="next_of_kin_name">Next of Kin Name:</label>
                            <input type="name" name="nok_name" class="form-control" id="nok_name" required
                                placeholder="Enter next of kin's name" value="{{ $patient->next_of_kin_name }}">
                        </div>
                        <div class="me-3">
                            <label for="next_of_kin_phone">Next of Kin Phone:</label>
                            <input type="phone" name="nok_phone" class="form-control" id="nok_phone" required
                                placeholder="Enter next of kin's phone number" value="{{ $patient->next_of_kin_phone }}">
                        </div>
                        <div>
                            <label for="next_of_kin_relation">Next of Kin Relationship:</label>
                            <input type="text" name="nok_relation" class="form-control" id="nok_relation" required
                                placeholder="Enter next of kin's relationship"
                                value="{{ $patient->next_of_kin_relationship }}">
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
    @endsection
</body>

</html>
