@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Appointments</h1>
                <a class="btn btn-success" href="{{ route('appointment.create') }}">Add New Appointment</a>
        </div>
        @if (count($appointments) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            Patient Name
                        </th>
                        <th>
                            Receptionist
                        </th>
                        <th scope="col">
                            Nurse Attendant
                        </th>
                        <th scope="col">
                            Doctor Attendant
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
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->name }}</td>
                            <td>{{ $appointment->receptionist->first_name }}</td>
                            <td>{{ optional($appointment->checkup)->nurse ? $appointment->checkup->nurse->first_name : 'N/A' }}
                            </td>
                            <td>{{ optional($appointment->diagnosis)->doctor ? $appointment->diagnosis->doctor->first_name : 'N/A' }}
                            </td>
                            <td>
                                <span
                                    class="px-2 rounded-3 py-1 {{ $appointment->status === 'completed' ? 'bg-success' : ($appointment->status === 'ongoing' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $appointment['status'] }}
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
                                        @if ($appointment['status'] == 'completed')
                                        @else
                                        <a class="dropdown-item"
                                            href="{{ route('appointment.checkup', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']]) }}">
                                            @if ($appointment['status'] == 'pending')
                                                Begin
                                            @else
                                                Continue
                                            @endif
                                        </a>    
                                        @endif
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $appointments->links('pagination::bootstrap-4') }}
        @else
            <h5 class="mt-3">No appointments found</h5>
        @endif
    </div>
@endsection
