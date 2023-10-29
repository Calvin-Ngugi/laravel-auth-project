@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Patients</h1>
                <form action="{{ route('patients.index') }}" method="GET" class="align-items-end d-flex">
                    <div class="form-group">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Enter patient name">
                    </div>
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                </form>
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
                                <a href="{{ route('patients.index', ['sort_by' => 'name', 'sort_order' => $sortColumn === 'name' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                    class="text-light text-decoration-none">Name
                                    @if ($sortColumn == 'name')
                                        @if ($sortOrder == 'asc')
                                            <i class="bi-caret-up-fill"></i>
                                        @else
                                            <i class="bi-caret-down-fill"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ route('patients.index', ['sort_by' => 'gender', 'sort_order' => $sortColumn === 'gender' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                    class="text-light text-decoration-none">Gender
                                    @if ($sortColumn == 'gender')
                                        @if ($sortOrder == 'asc')
                                            <i class="bi-caret-up-fill"></i>
                                        @else
                                            <i class="bi-caret-down-fill"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ route('patients.index', ['sort_by' => 'dob', 'sort_order' => $sortColumn === 'dob' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                    class="text-light text-decoration-none">Date of Birth
                                    @if ($sortColumn == 'dob')
                                        @if ($sortOrder == 'asc')
                                            <i class="bi-caret-up-fill"></i>
                                        @else
                                            <i class="bi-caret-down-fill"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ route('patients.index', ['sort_by' => 'phone_number', 'sort_order' => $sortColumn === 'phone_number' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                    class="text-light text-decoration-none">Phone Number
                                    @if ($sortColumn == 'phone_number')
                                        @if ($sortOrder == 'asc')
                                            <i class="bi-caret-up-fill"></i>
                                        @else
                                            <i class="bi-caret-down-fill"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ route('patients.index', ['sort_by' => 'id_number', 'sort_order' => $sortColumn === 'id_number' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                    class="text-light text-decoration-none">Id Number
                                    @if ($sortColumn == 'id_number')
                                        @if ($sortOrder == 'asc')
                                            <i class="bi-caret-up-fill"></i>
                                        @else
                                            <i class="bi-caret-down-fill"></i>
                                        @endif
                                    @endif
                                </a>
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
                                <td>{{ $patient['id_number'] }}</td>
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
                {{ $patients->appends(request()->input())->links('pagination::bootstrap-4') }}
            @else
                <h4>No patients found
                    </h2>
            @endif
        @endunless
    </div>
@endsection
