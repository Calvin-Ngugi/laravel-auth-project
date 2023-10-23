<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/roles.css">
    <title>Document</title>
</head>

<body>
    @extends('layout')
    @section('content')
        <div class="contain mr-2 pt-3">
            <div>
                <h2>Role Name: {{ $role->name }}</h2> 
            </div>
            <table class="table table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">
                            Permissions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($role->permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
</body>

</html>
