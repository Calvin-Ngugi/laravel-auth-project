@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Patients</h1>
                @can('create patients')
                    <a class="btn btn-success" href="{{ route('patients.create') }}">Add New Patient</a>
                @endcan
        </div>
        @unless (count($patients) == 0)
            @if (count($patients) > 0)
                <table class="table table-striped mt-3">
                    <thead class="thead-dark table-dark">
                        <tr>
                            <th scope="col">
                                Name
                            </th>
                            <th scope="col">
                                Gender
                            </th>
                            <th scope="col">
                                Date of Birth
                            </th>
                            <th scope="col">
                                Phone Number
                            </th>
                            <th scope="col">
                                Id Number
                            </th>
                            <th scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $patient)
                            <tr>
                                <td>{{ $patient['name'] }}</td>
                                <td>{{ $patient['gender'] }}</td>
                                <td>{{ $patient['dob'] }}</td>
                                <td>{{ $patient['phone_number'] }}</td>
                                <td>{{ $patient['id_number']}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                            role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('patients.edit', ['id' => $patient['id']]) }}">Edit</a>
                                            <a class="dropdown-item"
                                                href="{{ route('patients.show', ['id' => $patient['id']]) }}">View</a>
                                            {{-- @can('delete users')
                                                @if (!($user['role'] == 'superuser'))
                                                    @if ($user['status'] === 'active')
                                                        <a class="dropdown-item"
                                                            href="{{ route('deleteUser', ['id' => $user['id']]) }}">Delete</a>
                                                    @endif
                                                @endif
                                            @endcan
                                            @can('approve changes')
                                                @if ($user['status'] === 'pending')
                                                    <a class="dropdown-item"
                                                        href="{{ route('disableUser', ['id' => $user['id']]) }}">Disable</a>
                                                @endif
                                                @if ($user['status'] === 'pending' || $user['status'] === 'disabled')
                                                    <a class="dropdown-item"
                                                        href="{{ route('enableUser', ['id' => $user['id']]) }}">Enable</a>
                                                @endif
                                            @endcan --}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $patients->links('pagination::bootstrap-4') }}
            @else
                <h4>No patients found
                    </h2>
            @endif
        @endunless
    </div>
@endsection
