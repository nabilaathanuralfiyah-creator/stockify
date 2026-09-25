<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@stockify.com'],
            ['name' => 'Admin Stockify', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'staff@stockify.com'],
            ['name' => 'Staff Gudang', 'password' => Hash::make('password'), 'role' => 'staff']
        );
    }
}
