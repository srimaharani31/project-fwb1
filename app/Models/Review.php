<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',      // Siapa yang memberikan ulasan
        'product_id',   // Produk yang diulas
        'order_id',     // Pesanan terkait (jika ulasan hanya bisa diberikan setelah pembelian)
        'rating',
        'comment',
        'is_read',      // Bisa ditambahkan untuk menandai ulasan sudah dibaca owner
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
