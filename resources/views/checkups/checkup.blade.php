@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($checkup)
            <div class="row">
                <div class="col">
                    <h1 class="jumbotron mb-4 text-decoration-underline">Preliminary assessment</h1>
                    {{-- <a class="btn btn-primary" href="{{ route('checkups.checkups') }}">Add New Patient</a> --}}
                    <div class="row rows-cols-2 border">
                        <div class="col border p-4">
                            <h3>Preliminary assessment details</h3>
                            <p>Patient Name: {{ $checkup->patient->name }}</p>
                            <p>Height: {{ $checkup['height'] }}</p>
                            <p>Weight: {{ $checkup['weight'] }}</p>
                            <p>Temperature: {{ $checkup['temperature'] }}</p>
                            <p>Blood Pressure: {{ $checkup['blood_pressure'] }}</p>
                            <p>Blood Sugar: {{ $checkup['blood_sugar'] }}</p>
                            <p>Heart Rate: {{ $checkup['heart_rate'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <img src="https://cdn-icons-png.flaticon.com/512/65/65568.png"
                        alt="user" height="300px" class="mt-5 pt-5">
                </div>
                {{-- <div class="container mt-4">
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
                </div> --}}
            </div>
        @else
            <p>No assesment found.</p>
        @endif
    </div>
@endsection
