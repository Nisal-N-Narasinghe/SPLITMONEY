<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Kasun',
            'email' => 'kasun@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Nimal',
            'email' => 'nimal@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Amal',
            'email' => 'amal@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('admin@2026n'),
            'is_admin' => true,
        ]);
    }
}
