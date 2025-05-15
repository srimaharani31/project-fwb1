<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pakaian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Makanan & Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rumah Tangga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
   ]);
}
}