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
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'approve changes']);
        Permission::create(['name' => 'create patients']);
        Permission::create(['name' => 'edit patients']);
        Permission::create(['name' => 'view patients']);

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $doctorRole = Role::create(['name' => 'doctor']);
        $nurseRole = Role::create(['name' => 'nurse']);
        $financeRole = Role::create(['name' => 'finance']);
        $labTechRole = Role::create(['name' => 'lab-tech']);
        // $checkerRole = Role::create(['name' => 'checker']);
        $receptionistRole = Role::create(['name' => 'receptionist']);

        // Assign permissions to roles
        $superAdminRole->syncPermissions([
            'view users',
            'create users',
            'view listings',
            'edit roles',
            'edit users',
            'delete users',
            'create roles',
            'view roles',
            'approve changes',
            'create patients',
            'edit patients',
            'view patients',
        ]);

        $doctorRole->syncPermissions([
            'view users',    
            'view listings',
            'create patients',
            'edit patients',
            'view patients',
        ]);

        $nurseRole->syncPermissions([
            'view users',
            'view listings',
            'create patients',
            'edit patients',
            'view patients',
        ]);

        $receptionistRole->syncPermissions([
            'view users',
            'view listings',
            'view patients',
            'create patients',
        ]);

        // Create a super admin user
        $superAdminUser = User::create([
            'username' => 'Valcin',
            'email' => 'ncalvin67@gmail.com',
            'password' => Hash::make('Protection'),
            'first_name' => 'Calvin',
            'last_name' => 'Ngugi',
            'change_pass' => 1,
            'status' => 'active',
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
