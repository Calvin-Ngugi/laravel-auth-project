<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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

    public function viewRole($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.viewRole', compact('role'));
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.editRole', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $role->name = $validatedData['name'];
        $role->save();

        return redirect()->route('admin.showRoles')->with('success', 'Role updated successfully');
    }

    public function createRole(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
        ]);

        $role = Role::create(['name' => $validatedData['name']]);
        $permissions = Permission::all();

        return view('admin.createRole', compact('role', 'permissions'));
    }
}
