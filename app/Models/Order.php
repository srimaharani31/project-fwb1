<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hapus atau komen baris ini:
    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function items() // Ini yang akan Anda gunakan secara konsisten
    {
        return $this->hasMany(OrderItem::class);
    }
}