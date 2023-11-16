@extends('appointmentLayout')

@section('content')
    <div class="mt-2 w-50 m-auto">
        <h2>Create Appointment</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form class="form" action="{{ route('appointment.post') }}" method="post">
            @csrf
            <div class="form-group mt-3 mb-3">
                <label for="permissions">Patients:</label>
                <select name="patient_id" id="patient_id" class="form-control">
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Appointment</button>
        </form>
    </div>
@endsection
