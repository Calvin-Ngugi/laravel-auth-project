<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function showRoles()
    {
        $roles = Role::with('permissions', 'users')->get();
        $users = User::all();
        return view('admin.showRoles', compact('roles', 'users'));
    }

    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->roles()->detach();
        $user->assignRole($request->role_id);

        return redirect()->back()->with('success', 'Role assigned successfully');
    }
}
