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
    <div class="mt-4 w-50 m-auto">
        <div class="card">
            <div class="card-header">
                Patient Billing Information
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>Consultation Fee</td>
                        <td>2500</td>
                        <td>paid</td>
                    </tr>
                    <tr>
                        <td>Services Fee</td>
                        <td>2500</td>
                        <td>unpaid</td>
                    </tr>
                    <tr>
                        <td>Medicines Fee</td>
                        <td>2500</td>
                        <td>unpaid</td>
                    </tr>
                    <tr class="table-primary">
                        <td>Total</td>
                        <td>2500</td>
                        <td>unpaid</td>
                    </tr>
                </table>
                <div class="justify-content-between d-flex">
                    <button class="btn btn-success"><i class="bi bi-currency-dollar"></i> <span>Checkout</span></button>
                    <form action="{{ route('appointment.checkout', ['appointmentId' => $appointment->id]) }}"
                        method="post">
                        @csrf
                        <button class="btn btn-primary" type="submit">
                            <span>checkout</span>
                            <i class="bi bi-arrow-right-circle"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
