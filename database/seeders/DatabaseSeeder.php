<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'view listings']);
        Permission::create(['name' => 'edit user roles']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $superAdminRole->syncPermissions([
            'view users',
            'create users',
            'view listings',
            'edit user roles',
            'edit users',
            'delete users'
        ]);

        $adminRole->syncPermissions([
            'view users',
            'create users',
            'view listings',
            'edit users',
            'delete users'
        ]);

        $userRole->syncPermissions([
            'view users',
            'view listings',
        ]);

        // Create a super admin user
        $superAdminUser = User::create([
            'username' => 'Valcin',
            'email' => 'ncalvin67@gmail.com',
            'password' => Hash::make('Protection'),
            'first_name' => 'Calvin',
            'last_name' => 'Ngugi',
            'change_pass' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $superAdminUser->assignRole('super-admin');
        
        // Create listings
        Listing::factory(7)->create();
        //  $user = User::factory(1)->create()[0];
        //  Listing::factory(7)->create();
        //  Role::create(['name' => 'super-admin']);
        //  Role::create(['name' => 'admin']);
        //  Role::create(['name' => 'user']);
        //  Permission::create(['name' => 'view users']);
        //  Permission::create(['name' => 'create users']);
        //  Permission::create(['name' => 'view listings']);
        //  Permission::create(['name' => 'edit user roles']);

        //  $user->assignRole('super-admin');
    }
}
