<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order; 
use App\Models\Product; 

class OrderItemSeeder extends Seeder
{

    public function run(): void
    {
        $order1 = Order::where('status', 'completed')->first(); 
        $order2 = Order::where('status', 'paid')->first(); 
        $order3 = Order::where('status', 'pending')->first(); 

        $laptop = Product::where('name', 'Laptop XYZ')->first();
        $tshirt = Product::where('name', 'T-Shirt Keren')->first();
        $kopi = Product::where('name', 'Kopi Bubuk Premium')->first();

        if (!$order1 || !$order2 || !$order3 || !$laptop || !$tshirt || !$kopi) {
             $this->command->info('Skipping OrderItemSeeder: Required orders or products not found.');
             return;
        }

        DB::table('order_items')->insert([
            [
                'order_id' => $order1->id,
                'product_id' => $laptop->id,
                'quantity' => 1,
                'price' => $laptop->price, // Ambil harga dari produk
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => $order1->id,
                'product_id' => $tshirt->id,
                'quantity' => 10,
                'price' => $tshirt->price,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => $order2->id,
                'product_id' => $kopi->id,
                'quantity' => 2,
                'price' => $kopi->price,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => $order3->id,
                'product_id' => $laptop->id,
                'quantity' => 1,
                'price' => $laptop->price,
                'created_at' => now(),
                'updated_at' => now(),
            ],
   ]);
}
}
