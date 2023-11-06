@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($medicine)
            <div class="row">
                <div class="col">
                    <h1 class="jumbotron mb-4 text-decoration-underline">Medicine</h1>
                    {{-- <a class="btn btn-primary" href="{{ route('checkups.checkups') }}">Add New Patient</a> --}}
                    <div class="row rows-cols-2 border">
                        <div class="col border p-4">
                            <h3>Medicine</h3>
                            <p>Name: {{ $medicine['name'] }}</p>
                            <p>Unit Cost: {{ $medicine['unit_cost'] }}</p>
                            <p>Number in inventory: {{ $medicine['no_in_inventory'] }}</p>
                            <p>Type: {{ $medicine['type'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <img src="https://cdn-icons-png.flaticon.com/512/1106/1106992.png" alt="user" height="300px"
                        class="mt-4 pt-5">
                </div>
            </div>
        @else
            <p>No medicine found.</p>
        @endif
    </div>
@endsection
