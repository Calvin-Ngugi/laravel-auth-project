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
                    <div class="row rows-cols-2 ">
                            @if ($appointment->checkup_id)
                            <div class="col border p-4">
                                <h3>Preliminary assessment details</h3>
                                <p>Date: {{ $appointment->checkup->updated_at->format('Y-m-d') }}</p>
                                <p>Nurse: {{ $appointment->checkup->nurse->username }}</p>
                                <p>Height: {{ $appointment->checkup['height'] }}</p>
                                <p>Weight: {{ $appointment->checkup['weight'] }}</p>
                                <p>Temperature: {{ $appointment->checkup['temperature'] }}</p>
                                <p>Blood Pressure: {{ $appointment->checkup['blood_pressure'] }}</p>
                                <p>Blood Sugar: {{ $appointment->checkup['blood_sugar'] }}</p>
                                <p>Heart Rate: {{ $appointment->checkup['heart_rate'] }}</p>
                            </div>
                    @endif
                    @if ($appointment->diagnosis)
                        <div class="col border p-4">
                            <h3>Diagnosis and Treatment details</h3>
                            <p>Date: {{ $appointment->diagnosis->updated_at->format('Y-m-d') }}</p>
                            <p>Disease: {{ $appointment->diagnosis['disease'] }}</p>
                            <p>Symptoms found: {{ $appointment->diagnosis['symptoms'] }}</p>
                            <p>Tests taken:
                                @foreach ($services as $service)
                                    @if ($appointment->diagnosis['tests'] === $service->id)
                                        {{ $service->name }}
                                    @endif
                                @endforeach
                            </p>
                            <p>Test results: {{ $appointment->diagnosis['test_results'] }}</p>
                            <p>Medicines prescribed: 
                                @foreach ($medicines as $medicine)
                                    @if ($appointment->diagnosis['treatments'] === $medicine->id)
                                        {{ $medicine->name }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    @endif
                </div>
            </div>
    </div>
    <div class="row rows-cols-2 border mt-2">
        @if ($appointment->billing_id)
            <div class="col border p-4">
                <h3>Billing details</h3>
                <p>Date: {{ $appointment->billing->updated_at->format('Y-m-d') }}</p>
                <p>Services cost: {{ $appointment->billing['services_cost'] }}</p>
                <p>Medicine cost: {{ $appointment->billing['medicine_cost'] }}</p>
                <p>Consultation Fee: 2500.00</p>
                <p>Consultation Fee status:
                    <span
                        class="px-2 rounded-3 py-1 {{ $appointment->billing->consultation_fee === 'paid' ? 'bg-success' : ($appointment->billing->consultation_fee === 'unpaid' ? 'bg-warning' : 'bg-danger') }}">
                        {{ $appointment->billing['consultation_fee'] }}
                    </span>
                </p>
                <p>Status:
                    <span
                        class="px-2 rounded-3 py-1 {{ $appointment->billing->status === 'paid' ? 'bg-success' : ($appointment->billing->status === 'unpaid' ? 'bg-warning' : 'bg-danger') }}">
                        {{ $appointment->billing['status'] }}
                    </span>
                </p>
            </div>
        @endif
        @if ($appointment->room_id)
            <div class="col border p-4">
                <h3>Current Room details</h3>
                <p>Date: {{ $appointment->room->updated_at->format('Y-m-d') }}</p>
                <p>Room name: {{ $appointment->room['name'] }}</p>
                <p>Attendant: {{ $appointment->room->role->name }}</p>
                <p>Status:
                    <span
                        class="px-2 rounded-3 py-1 {{ $appointment->room->status === 'available' ? 'bg-success' : ($appointment->room->status === 'occupied' ? 'bg-warning' : 'bg-danger') }}">
                        {{ $appointment->room['status'] }}
                    </span>
                </p>
            </div>
    </div>
    @endif
@else
    <p>No assesment found.</p>
    @endif
    </div>
@endsection
