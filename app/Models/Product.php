<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import for relationships
use Illuminate\Database\Eloquent\Relations\HasMany;   // Import for relationships

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'owner_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

 
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
}
}
