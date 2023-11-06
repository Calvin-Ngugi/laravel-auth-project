@extends('layout')

@section('content')
    <div class="contain">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2>Pharmacy</h1>
                <a class="btn btn-success" href="{{ route('medicine.create') }}">Add New Medicine</a>
        </div>
        @if (count($medicines) > 0)
            <table class="table table-striped mt-3">
                <thead class="thead-dark table-dark">
                    <tr>
                        <th scope="col">
                            Name
                        </th>
                        <th scope="col">
                            Unit Cost
                        </th>
                        <th scope="col">
                            Inventory
                        </th>
                        <th scope="col">
                            Type
                        </th>
                        <th scope="col">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine['name'] }}</td>
                            <td>{{ $medicine['unit_cost'] }}</td>
                            <td>{{ $medicine['no_in_inventory'] }}</td>
                            <td>{{ $medicine['type'] }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle"
                                        role="button" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item"
                                            href="{{ route('medicine.edit', ['id' => $medicine['id']]) }}">Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('medicine.show', ['id' => $medicine['id']]) }}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $medicines->links('pagination::bootstrap-4') }}
        @else
            <h4>No medicine found
                </h2>
        @endif
    </div>
@endsection
