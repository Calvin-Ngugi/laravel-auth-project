@extends('layout')

@section('content')
    <nav class="nav w-100 p-2 bg-light">
        @php
            $links = [['name' => 'Checkup', 'action' => 'appointment.checkup'], ['name' => 'Consultation', 'action' => 'appointment.create'], ['name' => 'Tests', 'action' => 'appointment.index'], ['name' => 'billing', 'action' => 'appointment.index']];
        @endphp

        <div class="max-w-50 m-auto d-flex justify-content-between">
            @foreach ($links as $link)
                <a class="nav-link {{ Route::currentRouteName() === 'appointment.checkup' ? 'active fw-bold' : '' }}" aria-current="page"
                    href={{ route($link['action']) }}>{{ $link['name'] }}</a>
            @endforeach
        </div>
    </nav>
    @yield('sub-content')
@endsection
