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
        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        return view('admin.editRole', compact('role', 'permissions'));
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'permissions' => 'array',  // Assuming 'permissions' is an array of permission names
        ]);

        $role->name = $validatedData['name'];
        $role->save();

        // Check if permissions were selected in the form
        if (isset($validatedData['permissions'])) {
            foreach ($validatedData['permissions'] as $permissionName) {
                // Attach the selected permissions to the role if they are not already attached
                if (!$role->hasPermissionTo($permissionName)) {
                    $role->givePermissionTo($permissionName);
                }
            }
        }

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    public function createRole(Request $request)
    {
        $permissions = Permission::all();  // Fetch all permissions (or filter as needed)

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'permissions' => 'array',  // Assuming 'permissions' is an array of permission IDs
            ]);

            // Create the role
            $role = Role::create(['name' => $validatedData['name']]);

            // Check if permissions were selected
            if (isset($validatedData['permissions'])) {
                // Attach the selected permissions to the role
                $role->syncPermissions($validatedData['permissions']);
            }

            // Return the view with role and permissions
            return redirect()->route('admin.showRoles')->with('success', 'Role created successfully');
            // return view('admin.createRole', compact('role', 'permissions'));
        } catch (\Exception $e) {
            // Handle any exceptions that might occur
            return view('admin.createRole', compact('permissions'))->with('error', 'An error occurred while creating the role.');
        }
    }

    public function removePermission(Request $request)
    {
        $role = Role::findOrFail($request->input('id'));

        $permissionName = $request->input('permission');

        // Revoke the specified permission from the role
        $role->revokePermissionTo($permissionName);

        return redirect()->back()->with('success', 'Permission removed from the role.');
    }
}
