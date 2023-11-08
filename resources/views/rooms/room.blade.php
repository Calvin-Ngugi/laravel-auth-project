@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($room)
            <div class="row">
                <div class="col">
                    <h1 class="jumbotron mb-4 text-decoration-underline">Room</h1>
                    {{-- <a class="btn btn-primary" href="{{ route('checkups.checkups') }}">Add New Patient</a> --}}
                    <div class="row rows-cols-2 border">
                        <div class="col border p-4">
                            <h3>Room:</h3>
                            <p>Name: {{ $room['name'] }}</p>
                            <p>Role Assigned: {{ $room->role->name }}</p>
                            <p>Capacity: {{ $room['capacity'] }}</p>
                            <p>Status: {{ $room['status'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <img src="https://cdn-icons-png.flaticon.com/512/1137/1137965.png" alt="user" height="300px"
                        class="mt-4 pt-5">
                </div>
            </div>
        @else
            <p>No room found.</p>
        @endif
    </div>
@endsection
