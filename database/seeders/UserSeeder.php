<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin POSIFY',
            'email' => 'admin@posify.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
            'is_active' => true,
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@posify.id',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'phone' => '081234567891',
            'address' => 'Jakarta, Indonesia',
            'is_active' => true,
        ]);

        // Pelanggan
        User::create([
            'name' => 'Pelanggan Demo',
            'email' => 'pelanggan@posify.id',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'phone' => '081234567892',
            'address' => 'Jakarta, Indonesia',
            'is_active' => true,
        ]);
    }
}
