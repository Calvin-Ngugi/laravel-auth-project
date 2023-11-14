@extends('layout')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Services</h1>
                <form action="{{ route('services.index') }}" method="GET" class="align-items-end d-flex">
                    <div class="form-group">
                        <input type="text" name="search" id="live-search" value="{{ request('search') }}"
                            class="form-control" placeholder="Enter service's name">
                    </div>
                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                </form>
                @can('create services')
                    <a class="btn btn-success" href="{{ route('services.create') }}">Add Service</a>
                @endcan
        </div>
        @if (count($services) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            <a href="{{ route('services.index', ['sort_by' => 'name', 'sort_order' => $sortColumn === 'name' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
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
                            <a href="{{ route('services.index', ['sort_by' => 'unit_cost', 'sort_order' => $sortColumn === 'unit_cost' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                class="text-light text-decoration-none">Unit Cost
                                @if ($sortColumn == 'unit_cost')
                                    @if ($sortOrder == 'asc')
                                        <i class="bi-caret-up-fill"></i>
                                    @else
                                        <i class="bi-caret-down-fill"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a href="{{ route('services.index', ['sort_by' => 'status', 'sort_order' => $sortColumn === 'status' ? ($sortOrder === 'asc' ? 'desc' : 'asc') : 'asc', 'search' => request('search')]) }}"
                                class="text-light text-decoration-none">Status
                                @if ($sortColumn == 'status')
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
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service['name'] }}</td>
                            <td>{{ $service['unit_cost'] }}</td>
                            <td>
                                <span
                                    class="px-2 rounded-3 py-1 {{ $service->status === 'available' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $service['status'] }}
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
                                        <a class="dropdown-item"
                                            href="{{ route('services.edit', ['id' => $service['id']]) }}">Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('services.show', ['id' => $service['id']]) }}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $services->links('pagination::bootstrap-4') }}
        @else
            <h5 class="mt-3">No services found</h5>
        @endif
    </div>
    <script defer>
        // Listen to the input event on the search input field
        document.getElementById('live-search').addEventListener('input', function() {
            const query = this.value;
            console.log(query);
            const resultsContainer = document.getElementById('live-search-results');

            // Make an AJAX request to fetch live search results
            fetch('{{ route('services.live-search') }}?query=' + query)
                .then(response => response.json())
                .then(results => {
                    // Clear previous results
                    resultsContainer.innerHTML = '';

                    // Display the new results within the table format
                    results.forEach(result => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${result.name}</td>
                        <td>${result.unit_cost}</td>
                        <td>
                            <span class="px-2 rounded-3 py-1 ${result.status === 'available' ? 'bg-success' : 'bg-danger' }">
                                ${result.status}
                            </span></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                    role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                        href="/services/${result.id}/edit">Edit</a>
                                    <a class="dropdown-item"
                                        href="/services/${result.id}">View</a>
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
@endsection
