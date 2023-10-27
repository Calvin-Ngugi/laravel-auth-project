@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Check Ups</h1>
                @can('create patients')
                    <a class="btn btn-success" href="{{ route('checkups.create') }}">Add Checkup</a>
                @endcan
        </div>
        @if (count($checkups) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            Patient Name
                        </th>
                        <th scope="col">
                            Height
                        </th>
                        <th scope="col">
                            Weight
                        </th>
                        <th scope="col">
                            Temperature
                        </th>
                        <th scope="col">
                            Blood Pressure
                        </th>
                        <th scope="col">
                            Blood Sugar
                        </th>
                        <th scope="col">
                            Heart Rate
                        </th>
                        <th scope="col">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($checkups as $checkup)
                        <tr>
                            <td>{{ $checkup->patient->name }}</td>
                            <td>{{ $checkup['height'] }}</td>
                            <td>{{ $checkup['weight'] }}</td>
                            <td>{{ $checkup['temperature'] }}</td>
                            <td>{{ $checkup['blood_pressure'] }}</td>
                            <td>{{ $checkup['blood_sugar'] }}</td>
                            <td>{{ $checkup['heart_rate'] }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                        role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('checkups.edit', ['id' => $checkup['id']])}}">Edit</a>
                                        <a class="dropdown-item" href="{{route('checkups.show', ['id' => $checkup['id']])}}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $checkups->links('pagination::bootstrap-4') }}
        @else
            <h5 class="mt-3">No checkups found
                </h2>
        @endif
    </div>
@endsection
