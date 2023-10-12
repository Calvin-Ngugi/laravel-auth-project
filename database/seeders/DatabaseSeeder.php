<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
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
         $user = User::factory(1)->create()[0];
         Listing::factory(7)->create();
         Role::create(['name' => 'super-admin']);
         Role::create(['name' => 'admin']);
         Role::create(['name' => 'user']);

         $user->assignRole('super-admin');
    }
}
