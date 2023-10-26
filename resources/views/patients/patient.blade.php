@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($patient)
            <div class="row">
                <div class="col">
                    <h1 class="jumbotron mb-4 text-decoration-underline">Patient</h1>
                    {{-- <a class="btn btn-primary" href="{{ route('checkups.checkups') }}">Add New Patient</a> --}}
                    <div class="row rows-cols-2 border">
                        <div class="col border p-4">
                            <h3>Patient details</h3>
                            <p>Name: {{ $patient['name'] }}</p>
                            <p>Gender: {{ $patient['gender'] }}</p>
                            <p>Date of Birth: {{ $patient['dob'] }}</p>
                            <p>Phone number: {{ $patient['phone_number'] }}</p>
                            <p>Id number: {{ $patient['id_number'] }}</p>
                        </div>
                        <div class="col border p-4">
                            <h3>Next of Kin Details</h3>
                            <p>Name: {{ $patient['next_of_kin_name'] }}</p>
                            <p>Relationship: {{ $patient['next_of_kin_relationship'] }}</p>
                            <p>Phone Number: {{ $patient['next_of_kin_phone'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <img src="https://static.vecteezy.com/system/resources/previews/008/442/086/non_2x/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg"
                        alt="user" height="300px" class="mt-5">
                </div>
                <div class="container mt-4">
                    <h3>Check-Up History for {{ $patient->name }}</h4>
                    <table class="table table-striped mt-3">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Height</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Temperature</th>
                                <th scope="col">Blood Pressure</th>
                                <th scope="col">Blood Sugar</th>
                                <th scope="col">Heart Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkUps as $checkUp)
                                <tr>
                                    <td>{{ $checkUp->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $checkUp->height }}</td>
                                    <td>{{ $checkUp->weight }}</td>
                                    <td>{{ $checkUp->temperature }}</td>
                                    <td>{{ $checkUp->blood_pressure }}</td>
                                    <td>{{ $checkUp->blood_sugar }}</td>
                                    <td>{{ $checkUp->heart_rate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>No patient found.</p>
        @endif
    </div>
@endsection
