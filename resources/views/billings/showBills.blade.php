@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Bills</h1>
        </div>
        @unless (count($billings) == 0)
            @if (count($billings) > 0)
                <table class="table table-striped mt-3">
                    <thead class="thead-dark table-dark">
                        <tr>
                            <th scope="col">
                                Accountant
                            </th>
                            <th scope="col">
                                Patient
                            </th>
                            <th scope="col">
                                Services cost
                            </th>
                            <th scope="col">
                                Medicine cost
                            </th>
                            <th scope="col">
                                Total
                            </th>
                            <th scope="col">
                                Consultation fee
                            </th>
                            <th scope="col">
                                Status
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($billings as $billing)
                            <tr>
                                <td>{{ $billing->finance->first_name }}</td>
                                <td>{{ $billing->appointment->patient->name }}</td>
                                <td>{{ $billing['services_cost'] }}</td>
                                <td>{{ $billing['medicine_cost'] }}</td>
                                <td>{{ $billing['total'] }}</td>
                                <td>
                                    <span
                                        class="px-2 rounded-3 py-1 {{ $billing->consultation_fee === 'paid' ? 'bg-success' : ($billing->consultation_fee === 'unpaid' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $billing['consultation_fee'] }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="px-2 rounded-3 py-1 {{ $billing->status === 'paid' ? 'bg-success' : ($billing->status === 'unpaid' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $billing['status'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                            role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">View</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $billings->links('pagination::bootstrap-4') }}
            @else
                <h5 class="mt-3">No bills found</h5>
            @endif
        @endunless
    </div>
@endsection
