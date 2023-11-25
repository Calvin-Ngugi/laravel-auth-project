@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($appointment)
            <div class="row">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-4 text-decoration-underline">Appointment for {{ $appointment->patient->name }}</h2>
                    <h2 class="mb-4 text-decoration-underline">Date: {{ $appointment->updated_at->format('Y-m-d') }}</h2>
                </div>
                <div class="col">
                    <div class="row rows-cols-2 border">
                        <div class="col border p-4">
                            <h3>Preliminary assessment details</h3>

                            <p>Date: {{ $appointment->checkup->updated_at->format('Y-m-d') }}</p>
                            <p>Height: {{ $appointment->checkup['height'] }}</p>
                            <p>Weight: {{ $appointment->checkup['weight'] }}</p>
                            <p>Temperature: {{ $appointment->checkup['temperature'] }}</p>
                            <p>Blood Pressure: {{ $appointment->checkup['blood_pressure'] }}</p>
                            <p>Blood Sugar: {{ $appointment->checkup['blood_sugar'] }}</p>
                            <p>Heart Rate: {{ $appointment->checkup['heart_rate'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col border p-4">
                    <h3>Diagnosis and Treatment details</h3>
                    <p>Date: {{ $appointment->diagnosis->updated_at->format('Y-m-d') }}</p>
                    <p>Disease: {{ $appointment->diagnosis['disease'] }}</p>
                    <p>Symptoms found: {{ $appointment->diagnosis['symptoms'] }}</p>
                    <p>Tests taken:
                        @foreach ($medicines as $medicine)
                            @if ($appointment->diagnosis['tests'] === $medicine->id)
                                {{ $medicine->name }}
                            @endif
                        @endforeach
                    </p>
                    <p>Blood Pressure: {{ $appointment->checkup['blood_pressure'] }}</p>
                    <p>Blood Sugar: {{ $appointment->checkup['blood_sugar'] }}</p>
                    <p>Heart Rate: {{ $appointment->checkup['heart_rate'] }}</p>
                </div>
            </div>
        @else
            <p>No assesment found.</p>
        @endif
    </div>
@endsection
