<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang kuat di produksi
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Owner Toko A',
                'email' => 'owner1@example.com',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Owner Toko B',
                'email' => 'owner2@example.com',
                'password' => Hash::make('password'),
                'role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pelanggan Biasa',
                'email' => 'pelanggan1@example.com',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pelanggan Setia',
                'email' => 'pelanggan2@example.com',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
   ]);
}
}