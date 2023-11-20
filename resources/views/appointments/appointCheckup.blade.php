@extends('layout')

@section('content')
    <nav class="nav w-100 p-2 mb-2 bg-light" style="margin-top: -8px;">
        <div class="max-w-50 m-auto d-flex justify-content-between">
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.checkup' ? 'active fw-bold' : '' }}"
                aria-current="page"
                href="{{ route('appointment.checkup', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">checkup</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.create' ? 'active fw-bold' : '' }}"
                aria-current="page"
                href="{{ route('appointment.diagnosis', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">diagnosis</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.billing ' ? 'active fw-bold' : '' }}"
                aria-current="page"
                href="{{ route('appointment.billing', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">billing</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.index' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.index') }}">pharmacy</a>
        </div>
    </nav>
    <div class="w-50 m-auto">
        <form class="form" action="{{ route('appointment.postCheckup', ['appointmentId' => $appointment->id]) }}"
            method="post">
            @csrf
            <h1 class="title">Patient Checkup</h1>
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
                    <label for="patient name">Patient Name:</label>
                    <select name="patient_id" id="patient_id" class="form-control">
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="height">Height:</label>
                    <input type="text" name="height" class="form-control" placeholder="Enter Height"
                        value="{{ old('height', $previousCheckup->height ?? '') }}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="weight">Weight:</label>
                    <input type="text" name="weight" class="form-control" required
                        value="{{ old('weight', $previousCheckup->weight ?? '') }}" placeholder="Enter Weight">
                </div>

                <div class="form-group mb-2">
                    <label for="temperature">Temperature:</label>
                    <input type="text" name="temperature" class="form-control" required
                        value="{{ old('temperature', $previousCheckup->temperature ?? '') }}"
                        placeholder="Enter temperature">
                </div>

                <div class="form-group mb-2">
                    <label for="pressure">Blood Pressure:</label>
                    <input type="text" name="blood_pressure" class="form-control"
                        value="{{ old('blood_pressure', $previousCheckup->blood_pressure ?? '') }}" required
                        placeholder="Enter blood pressure">
                </div>
                <div class="form-group mb-2">
                    <label for="pressure">Blood sugar:</label>
                    <input type="text" name="blood_sugar" class="form-control"
                        value="{{ old('blood_sugar', $previousCheckup->blood_sugar ?? '') }}" required
                        placeholder="Enter blood sugar">
                </div>

                <div class="form-group mb-2">
                    <label for="heart_rate">Heart Rate:</label>
                    <input type="text" name="heart_rate" class="form-control"
                        value="{{ old('heart_rate', $previousCheckup->heart_rate ?? '') }}" required
                        placeholder="Enter heart rate">
                </div>
            </div>
            <div class="justify-content-between d-flex">
                @can('create checkups')
                    <button class="btn btn-success" type="submit">Submit</button>
                @endcan
        </form>
        @if ($previousCheckup)
            <form action="{{ route('appointments.proceedToDiagnosis', ['appointmentId' => $appointment->id]) }}"
                method="post">
                @csrf
                <button class="btn btn-primary" type="submit">
                    <span>Proceed to Diagnosis</span>
                    <i class="bi bi-arrow-right-circle"></i>
                </button>
            </form>
        @endif
    </div>
    </div>
@endsection
