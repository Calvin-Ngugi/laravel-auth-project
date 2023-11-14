@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Rooms</h1>
                <a class="btn btn-success" href="{{ route('rooms.create') }}">Add New Room</a>
        </div>
        @if (count($rooms) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Role Assigned
                        </th>
                        <th scope="col">
                            Capacity
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
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room['name'] }}</td>
                            <td>{{ $room->role->name }}</td>
                            <td>{{ $room['capacity'] }}</td>
                            <td>
                                <span
                                    class="px-2 rounded-3 py-1 {{ $room->status === 'available' ? 'bg-success' : ($room->status === 'occupied' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $room['status'] }}
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
                                            href="{{ route('rooms.edit', ['id' => $room['id']]) }}">Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('rooms.show', ['id' => $room['id']]) }}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $rooms->links('pagination::bootstrap-4') }}
        @else
            <h5 class="mt-3">No rooms found</h5>
        @endif
    </div>
@endsection
