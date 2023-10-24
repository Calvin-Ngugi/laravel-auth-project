@extends('layout')

@section('content')
    <div class="ml-25 container">
        @if ($user)
            <div class="row">
                <div class="col">
                    <h1 class="jumbotron mb-4 text-decoration-underline">User</h1>
                    <p>Username: {{ $user['username'] }}</p>
                    <p>Email: {{ $user['email'] }}</p>
                    <p>First Name: {{ $user['first_name'] }}</p>
                    <p>Last Name: {{ $user['last_name'] }}</p>
                    <p>Status: <span
                            class="px-2 rounded-3 py-1 {{ $user->status === 'active' ? 'bg-success' : ($user->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">{{ $user['status'] }}</span>
                    </p>
                </div>
                <div class="col text-end">
                    <img src="https://static.vecteezy.com/system/resources/previews/008/442/086/non_2x/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg"
                        alt="user" height="300px">
                </div>
            </div>
        @else
            <p>No user found.</p>
        @endif
    </div>
@endsection
