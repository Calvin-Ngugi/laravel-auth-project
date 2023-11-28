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
                        <td>2000.00</td>
                        <td>{{ $appointment->billing->consultation_fee }}</td>
                    </tr>
                    <tr>
                        <td>Services Fee</td>
                        <td data-services-cost="{{ $appointment->billing['services_cost'] }}">
                            {{ $appointment->billing->services_cost }}</td>
                        <td>{{ $appointment->billing->status }}</td>
                    </tr>
                    <tr>
                        <td>Medicines Fee</td>
                        <td data-medicine-cost="{{ $appointment->billing['medicine_cost'] }}">
                            {{ $appointment->billing->medicine_cost }}</td>
                        <td>{{ $appointment->billing->status }}</td>
                    </tr>
                    <tr class="table-primary">
                        <td>Total</td>
                        <td data-total="{{ $appointment->billing['total'] }}">{{ $appointment->billing->total }}</td>
                        <td data-status="{{ $appointment->billing['status'] }}">{{ $appointment->billing->status }}</td>
                    </tr>
                </table>
                <div class="justify-content-between d-flex">
                    <form action="{{ route('appointment.payTotal', ['appointmentId' => $appointment->id]) }}"
                        method="post">
                        @csrf
                        <button class="btn btn-success" type="submit">
                            <i class="bi bi-currency-dollar"></i>
                            <span>Checkout</span>
                        </button>
                    </form>
                    @if ($appointment->billing->total > 0)
                    <form action="{{ route('appointment.checkout', ['appointmentId' => $appointment->id]) }}"
                        method="post">
                        @csrf
                        <button class="btn btn-primary" type="submit">
                            <span>checkout</span>
                            <i class="bi bi-arrow-right-circle"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Function to update the total
            function updateTotal() {
                var overallTotal = 0;

                // Loop through each row in the table
                $('tbody').each(function() {
                    var servicesCost = parseFloat($(this).find('td[data-services-cost]').text()) || 0;
                    var medicineCost = parseFloat($(this).find('td[data-medicine-cost]').text()) || 0;
                    var status = '{{ $appointment->billing->status }}';

                    // Calculate the total for each row and add it to the overall total
                    if (status == 'unpaid'){
                        var rowTotal = servicesCost + medicineCost;
                        overallTotal += rowTotal;
    
                        // Update the total cell for the current row
                        $(this).find('td[data-total]').text(rowTotal.toFixed(2));
                    }
                });

                // Display the overall total somewhere on the page
                $('#overall-total').text('Overall Total: $' + overallTotal.toFixed(2));
            }

            updateTotal();
        });
    </script>
@endsection
