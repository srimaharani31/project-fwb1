<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Asumsi model User ada

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggan1 = User::where('email', 'pelanggan1@example.com')->first();
        $pelanggan2 = User::where('email', 'pelanggan2@example.com')->first();

         if (!$pelanggan1 || !$pelanggan2) {
             $this->command->info('Skipping OrderSeeder: Required users not found.');
             return;
        }

        DB::table('orders')->insert([
            [
                'user_id' => $pelanggan1->id,
                'total_price' => 15150000.00, // Contoh total harga (sesuaikan dengan item nanti)
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $pelanggan2->id,
                'total_price' => 75000.00, // Contoh total harga
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $pelanggan1->id,
                'total_price' => 0.00, // Contoh order baru
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
   ]);
}
}
