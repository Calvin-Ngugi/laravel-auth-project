@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Check Ups</h1>
                <form action="{{ route('checkups.index') }}" method="GET" class="align-items-end d-flex">
                    <div class="form-group">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Enter patient's name">
                    </div>
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                </form>
                @can('create patients')
                    <a class="btn btn-success" href="{{ route('checkups.create') }}">Add Checkup</a>
                @endcan
        </div>
        @if (count($checkups) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'patients.name', 'sort_order' => $sortColumn == 'patients.name' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Patient Name
                                @if ($sortColumn == 'patients.name')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'height', 'sort_order' => $sortColumn == 'height' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Height
                                @if ($sortColumn == 'height')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'weight', 'sort_order' => $sortColumn == 'weight' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Weight
                                @if ($sortColumn == 'weight')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'temperature', 'sort_order' => $sortColumn == 'temperature' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Temperature
                                @if ($sortColumn == 'temperature')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'blood_pressure', 'sort_order' => $sortColumn == 'blood_pressure' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Blood pressure
                                @if ($sortColumn == 'blood_pressure')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'blood_sugar', 'sort_order' => $sortColumn == 'blood_sugar' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Blood sugar
                                @if ($sortColumn == 'blood_sugar')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a
                                href="{{ route('checkups.index', ['sort_by' => 'heart_rate', 'sort_order' => $sortColumn == 'heart_rate' && $sortOrder == 'asc' ? 'desc' : 'asc']) }}"
                                class="text-light text-decoration-none">
                                Heart rate
                                @if ($sortColumn == 'heart_rate')
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
                                        <a class="dropdown-item"
                                            href="{{ route('checkups.edit', ['id' => $checkup['id']]) }}">Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('checkups.show', ['id' => $checkup['id']]) }}">View</a>
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
