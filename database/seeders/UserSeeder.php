<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'Dr Sajjad',
            'email' => 'dr.sajjad@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('admin', 'user');

        $user = User::create([
            'name' => 'Muhammad Abbas',
            'email' => 'abbas.sscs@gmail.com',
            'password' => Hash::make('password'),

        ]);

        $user->assignRole(['admin', 'user']);

        $user = User::create([
            'name' => 'Data Expert',
            'email' => 'data@exampixel.com',
            'password' => Hash::make('password'),

        ]);

        $user->assignRole('operator');
    }
}
