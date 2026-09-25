<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna Multi-Role
        User::create([
            'name' => 'Admin Stockify',
            'email' => 'admin@stockify.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Manajer Gudang',
            'email' => 'manager@stockify.com',
            'password' => Hash::make('password'),
            'role' => 'manager'
        ]);

        User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@stockify.com',
            'password' => Hash::make('password'),
            'role' => 'staff'
        ]);

        // 2. Kategori Produk Awal
        Category::create(['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Perangkat elektronik dan aksesoris']);
        Category::create(['name' => 'Pakaian', 'slug' => 'pakaian', 'description' => 'Pakaian dan tekstil']);

        // 3. Supplier Awal
        Supplier::create([
            'name' => 'PT Elektronik Jaya',
            'phone' => '081234567890',
            'email' => 'contact@elektronikjaya.com',
            'address' => 'Jl. Industri No. 45, Jakarta'
        ]);
    }
}
