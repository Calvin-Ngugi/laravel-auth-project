@extends('layout')

@section('content')
    <div class="mt-2 w-75 m-auto">
            <h2>Create Patient Diagnosis</h2>
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form class="form" action="{{ route('diagnosis.post') }}" method="post">
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
                        @foreach ($patients as $patient)
                            <option value="{{$patient['id']}}">{{$patient['name']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="Symptoms">Symptoms:</label>
                    <textarea name="symptoms" id="symptoms" cols="15" rows="5" class="form-control"></textarea>
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="tests">Tests:</label>
                    @foreach ($tests as $test)
                        <div class="form-check">
                            <input type="checkbox" name="tests[]" value="{{ $test->name }}"
                                id="test{{ $test->name }}">
                            <label for="test{{ $test->name }}"
                                class="form-check-label">{{ $test->name }}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group mt-3 mb-3">
                    <label for="test_results">Test Results:</label>
                    <textarea name="test_results" id="test_results" cols="15" rows="5" class="form-control"></textarea>
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
                            <label for="medicine{{ $medicine->name }}"
                                class="form-check-label">{{ $medicine->name }}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
@endsection