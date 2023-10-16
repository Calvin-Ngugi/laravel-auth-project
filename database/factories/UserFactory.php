<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => 'Valcin',
            'email' => 'ncalvin67@gmail.com',
            'password' => Hash::make('Protection'),
            'first_name' => 'Calvin',
            'last_name' => 'Ngugi',
            'change_pass' => 1,
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
