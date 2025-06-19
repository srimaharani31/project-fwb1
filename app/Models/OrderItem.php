<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Properti yang bisa diisi secara massal
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price', // Simpan harga produk saat pesanan dibuat (harga historis)
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
        
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}