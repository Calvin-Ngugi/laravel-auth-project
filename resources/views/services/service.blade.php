@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($service)
            <div class="row">
                <div class="col">
                    <h1 class="jumbotron mb-4 text-decoration-underline">Service</h1>
                    {{-- <a class="btn btn-primary" href="{{ route('checkups.checkups') }}">Add New Patient</a> --}}
                    <div class="row rows-cols-2 border">
                        <div class="col border p-4">
                            <h3>Service</h3>
                            <p>Name: {{ $service['name'] }}</p>
                            <p>Unit Cost: {{ $service['unit_cost'] }}</p>
                            <p>Status: {{ $service['status'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <img src="https://cdn-icons-png.flaticon.com/512/78/78524.png" alt="user" height="300px"
                        class="mt-1 pt-5">
                </div>
            </div>
        @else
            <p>No service found.</p>
        @endif
    </div>
@endsection
