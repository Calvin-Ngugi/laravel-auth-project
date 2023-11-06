<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/users.css" title="roles">
    <title>HISP Roles</title>
</head>

<body>
    @extends('layout')

    @section('content')
        <div class="contain mr-2">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h2>Roles</h1>
                    <a class="btn btn-success" href="{{ route('admin.createRole') }}">Add New Role</a>
            </div>
            <table class="table table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">
                            Role
                        </th>
                        <th scope="col" class="text-center">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role['name'] }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary px-3 border-0 cursor-pointer rounded-circle" role="button" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{route('admin.editRole', ['id' => $role['id']])}}">Edit</a>
                                        <a class="dropdown-item" href="{{route('admin.viewRole', ['id' => $role['id']])}}">View</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </tbody>
            </table>
        </div>
    @endsection
</body>

</html>
