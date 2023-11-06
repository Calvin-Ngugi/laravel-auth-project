@extends('layout')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Services</h1>
                @can('create services')
                    <a class="btn btn-success" href="{{ route('services.create') }}">Add Service</a>
                @endcan
        </div>
        @if (count($services) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Unit cost
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
            <h4>No services found
        @endif

    </div>
@endsection
