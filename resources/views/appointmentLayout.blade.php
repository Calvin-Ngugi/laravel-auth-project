@extends('layout')

@section('content')
    <nav class="nav w-100 p-2 mb-2 bg-light" style="margin-top: -8px;">
        <div class="max-w-50 m-auto d-flex justify-content-between">
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.checkup' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.create') }}">checkup</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.create' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.create') }}">diagnosis</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.index' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.create') }}">billing</a>
            <a class="nav-link {{ Route::currentRouteName() === 'appointment.index' ? 'active fw-bold' : '' }}"
                aria-current="page" href="{{ route('appointment.index') }}">pharmacy</a>
        </div>
    </nav>
    @yield('sub-content')
@endsection
