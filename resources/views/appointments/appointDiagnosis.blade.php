@extends('layout')

@section('content')
    <nav class="nav w-100 p-2 mb-2 bg-light" style="margin-top: -8px;">
        <div class="max-w-50 m-auto d-flex justify-content-between">
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.checkup' ? 'active fw-bold' : '' }}"
                aria-current="page"
                href="{{ route('appointment.checkup', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">checkup</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.diagnosis' ? 'active fw-bold' : '' }}"
                aria-current="page"
                href="{{ route('appointment.diagnosis', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">diagnosis</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.index' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.create') }}">billing</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.index' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.index') }}">pharmacy</a>
        </div>
    </nav>
    <div class="mt-2 w-50 m-auto">
        <h1>Patient Diagnosis</h1>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form class="form" action="{{ route('appointment.postDiagnosis', ['appointmentId' => $appointment->id]) }}" method="post">
            @csrf
            @error('patient_id')
                <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
            @enderror
            @error('symptoms')
                <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
            @enderror
            @error('test')
                <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
            @enderror
            @error('test_results')
                <span class="alert alert-danger" role="alert" class="text-danger">{{ $message }}</span>
            @enderror
            <div class="form-group">
                <label for="name">Patient Name:</label>
                <select name="patient_id" id="patient_id" class="form-control">
                    <option value="{{ $patient['id'] }}">{{ $patient['name'] }}</option>
                </select>
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="Symptoms">Symptoms:</label>
                <textarea name="symptoms" id="symptoms" cols="15" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="tests">Tests:</label>
                @foreach ($tests as $test)
                    <div class="form-check">
                        <input type="checkbox" name="test[]" value="{{ $test->name }}" id="test{{ $test->name }}">
                        <label for="test{{ $test->name }}" class="form-check-label">{{ $test->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="test_results">Test Results:</label>
                <textarea name="test_results" id="test_results" cols="15" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="disease">Disease:</label>
                <input type="text" name="disease" id="disease" class="form-control">
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="treatments">Treatments:</label>
                @foreach ($medicines as $medicine)
                    <div class="form-check">
                        <input type="checkbox" name="treatments[]" value="{{ $medicine->name }}"
                            id="medicine{{ $medicine->name }}">
                        <label for="medicine{{ $medicine->name }}" class="form-check-label">{{ $medicine->name }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Proceed to Billing</button>
        </form>
    </div>
@endsection
