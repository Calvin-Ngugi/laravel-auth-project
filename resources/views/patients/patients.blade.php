@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Patients</h1>
                <form action="{{ route('patients.index') }}" method="GET" class="align-items-end d-flex">
                    <div class="form-group">
                        <input type="text" name="search" id="live-search" value="{{ request('search') }}"
                            class="form-control" placeholder="Enter patient's id number">
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
                    <tbody id="live-search-results">
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $patients->appends(request()->input())->links('pagination::bootstrap-4') }}
            @else
                <h5 class="mt-3">No patients found</h5>
            @endif
        @endunless
    </div>

    @unless (count($patients) == 0)
        <script defer>
            // Listen to the input event on the search input field
            document.getElementById('live-search').addEventListener('input', function() {
                const query = this.value;
                console.log(query);
                const resultsContainer = document.getElementById('live-search-results');

                // Make an AJAX request to fetch live search results
                fetch('{{ route('patients.live-search') }}?query=' + query)
                    .then(response => response.json())
                    .then(results => {
                        // Clear previous results
                        resultsContainer.innerHTML = '';

                        // Display the new results within the table format
                        results.forEach(result => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td>${result.name}</td>
                        <td>${result.gender}</td>
                        <td>${result.dob}</td>
                        <td>${result.phone_number}</td>
                        <td>${result.id_number}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                    role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                        href="/patients/${result.id}/edit">Edit</a>
                                    <a class="dropdown-item"
                                        href="/patients/${result.id}">View</a>
                                </div>
                            </div>
                        </td>
                    `;
                            resultsContainer.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Live search failed:', error);
                    });
            });
        </script>
    @endunless

@endsection
