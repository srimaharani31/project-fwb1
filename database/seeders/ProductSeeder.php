<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use App\Models\Category; 

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner1 = User::where('email', 'owner1@example.com')->first();
        $owner2 = User::where('email', 'owner2@example.com')->first();
        $categoryElektronik = Category::where('name', 'Elektronik')->first();
        $categoryPakaian = Category::where('name', 'Pakaian')->first();
        $categoryMakanan = Category::where('name', 'Makanan & Minuman')->first();

        if (!$owner1 || !$owner2 || !$categoryElektronik || !$categoryPakaian || !$categoryMakanan) {
             // Handle case where required users or categories don't exist
             $this->command->info('Skipping ProductSeeder: Required users or categories not found.');
             return;
        }


        DB::table('products')->insert([
            [
                'owner_id' => $owner1->id,
                'category_id' => $categoryElektronik->id,
                'name' => 'Laptop XYZ',
                'description' => 'Laptop canggih untuk produktivitas tinggi.',
                'price' => 15000000.00,
                'stock' => 50,
                'image' => null, // Atau path gambar jika ada
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'owner_id' => $owner1->id,
                'category_id' => $categoryPakaian->id,
                'name' => 'T-Shirt Keren',
                'description' => 'Kaos katun berkualitas dengan desain menarik.',
                'price' => 150000.00,
                'stock' => 200,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'owner_id' => $owner2->id,
                'category_id' => $categoryMakanan->id,
                'name' => 'Kopi Bubuk Premium',
                'description' => 'Kopi pilihan dengan aroma kuat.',
                'price' => 75000.00,
                'stock' => 100,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'owner_id' => $owner2->id,
                'category_id' => null, // Produk tanpa kategori
                'name' => 'Produk Unik',
                'description' => 'Deskripsi singkat produk unik.',
                'price' => 50000.00,
                'stock' => 30,
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
]);
}
}
