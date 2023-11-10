@extends('appointmentLayout')

@section('sub-content')
    <div class="w-50 m-auto">
            <form class="form" action="{{ route('checkups.post') }}" method="post">
                @csrf
                <h1 class="title">Add New Checkup</h1>
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
                        <label for="height">Height:</label>
                        <input type="text" name="height" class="form-control" placeholder="Enter Height" required>
                    </div>

                    <div class="form-group mb-2">
                        <label for="weight">Weight:</label>
                        <input type="text" name="weight" class="form-control" required placeholder="Enter Weight">
                    </div>

                    <div class="form-group mb-2">
                        <label for="temperature">Temperature:</label>
                        <input type="text" name="temperature" class="form-control" required
                            placeholder="Enter temperature">
                    </div>

                        <div class="form-group mb-2">
                            <label for="pressure">Blood Pressure:</label>
                            <input type="text" name="blood_pressure" class="form-control" required
                                placeholder="Enter blood pressure">
                        </div>
                        <div class="form-group mb-2">
                            <label for="pressure">Blood sugar:</label>
                            <input type="text" name="blood_sugar" class="form-control" required
                                placeholder="Enter blood sugar">
                        </div>                 

                    <div class="form-group mb-2">
                        <label for="heart_rate">Heart Rate:</label>
                        <input type="text" name="heart_rate" class="form-control" required
                            placeholder="Enter heart rate">
                    </div>
                </div>
                <button class="btn btn-success" type="submit">Submit</button>
            </form>
        </div>
@endsection