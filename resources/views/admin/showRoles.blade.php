@extends('layout') <!-- Assuming you have a layout file -->

@section('content')
    <div class="container">
        <h1>Roles and Permissions</h1>

        @foreach($roles as $role)
            <div class="card mb-3">
                <div class="card-header">
                    Role: {{ $role->name }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">Permissions:</h5>
                    <ul>
                        @foreach($role->permissions as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>

                    <h5 class="card-title">Users:</h5>
                    <ul>
                        @foreach($role->users as $user)
                            <li>{{ $user->name }}</li>
                        @endforeach
                    </ul>

                    <form action="{{ url('/admin/assign-role') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                        <label for="user_id">Assign Role to User:</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">Assign Role</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
