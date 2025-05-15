<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import for relationships
use Illuminate\Database\Eloquent\Relations\HasMany;   // Import for relationships

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    /**
     * Get the user who placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accessor for total_price to ensure it's treated as a float/decimal.
     * Optional: Depends on how strict you want type casting.
     *
     * protected function totalPrice(): Attribute
     * {
     * return Attribute::make(
     * get: fn (string $value) => (float) $value,
     * );
     * }
     */
}
