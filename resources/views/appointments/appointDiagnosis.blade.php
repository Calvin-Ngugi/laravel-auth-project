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
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.billing' ? 'active fw-bold' : '' }}"
                aria-current="page"
                href="{{ route('appointment.billing', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">billing</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.index' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.index') }}">back to list</a>
        </div>
    </nav>
    <div class="mt-2 w-50 m-auto">
        <h1>Patient Diagnosis</h1>
        <form class="form" action="{{ route('appointment.postDiagnosis', ['appointmentId' => $appointment->id]) }}"
            method="post">
            @csrf
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
                <textarea name="symptoms" id="symptoms" cols="15" rows="3" class="form-control">{{ old('symptoms', $previousDiagnosis->symptoms ?? '') }}</textarea>
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="tests">Tests:</label>
                @foreach ($tests as $test)
                    <div class="form-check">
                        <input type="checkbox" name="tests[]" value="{{ $test->id }}" id="tests{{ $test->id }}"
                            {{ in_array($test->id, old('tests', json_decode($previousDiagnosis->tests ?? '[]', true))) ? 'checked' : '' }}>
                        <label for="test{{ $test->id }}" class="form-check-label">{{ $test->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="test_results">Test Results:</label>
                <textarea name="test_results" id="test_results" cols="15" rows="3" class="form-control">{{ old('symptoms', $previousDiagnosis->test_results ?? '') }}</textarea>
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="disease">Disease:</label>
                <input type="text" name="disease" id="disease"
                    value="{{ old('disease', $previousDiagnosis->disease ?? '') }}" class="form-control">
            </div>
            <div class="form-group mt-3 mb-3">
                <label for="treatments">Treatments:</label>
                @foreach ($medicines as $index => $medicine)
                    <div class="form-check d-flex align-items-center justify-content-between">
                        <label class="form-check-label d-flex align-items-center justify-content-center" style="gap: 2px;">
                            <input class="form-check-input" type="checkbox" name="treatments[]" value={{ $medicine->id }}
                                {{ in_array($medicine->id, old('treatments', json_decode($previousDiagnosis->treatments ?? '[]'))) ? 'checked' : '' }}>
                            {{ $medicine->name }} </label>
                        <div class="mt-1">
                            <label>Quantity</label>
                            <input class="form-control" type="number" name="quantity[]" placeholder="Enter quantity"
                                {{-- value="{{ $previousDiagnosis->prescriptions[$index]->quantity ?? '' }}"  --}}
                                {{ in_array($medicine->id, old('treatments', json_decode($previousDiagnosis->treatments ?? '[]'))) ? '' : 'disabled' }}>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="justify-content-between d-flex">
                @can('edit diagnosis')
                    <button type="submit" class="btn btn-success">Submit</button>
                @endcan
        </form>
        @if ($previousDiagnosis)
            <form action="{{ route('appointment.proceedToBilling', ['appointmentId' => $appointment->id]) }}"
                method="post">
                @csrf
                <button class="btn btn-primary" type="submit">
                    <span>Proceed to Billing</span>
                    <i class="bi bi-arrow-right-circle"></i>
                </button>
            </form>
        @endif
    </div>
    </div>
    <script defer>
        $(document).ready(function() {
            $('input[name="treatments[]"]').change(function() {
                // Find the corresponding quantity input
                var quantityInput = $(this).closest('.form-check').find('input[name="quantity[]"]');
                // Enable/disable the quantity input based on checkbox state
                quantityInput.prop('disabled', !$(this).prop('checked'));
            });
        });
    </script>
@endsection
