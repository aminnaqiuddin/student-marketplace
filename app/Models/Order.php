<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'user_id', // Ensure this is included
        'name',
        'email',
        'address',
        'total_price',
        'status', // Recommended to track order status
        'stripe_payment_id',
        'stripe_session_id',
        'stripe_payment_intent',
    ];

    protected $casts = [
        'total_price' => 'decimal:2', // Proper decimal casting
    ];

    /**
     * Relationship with order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship with the user who placed the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all products in this order
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                   ->using(OrderItem::class)
                   ->withPivot(['quantity', 'price'])
                   ->withTimestamps();
    }

    /**
     * Calculate total items in order
     */
    public function totalItems(): int
    {
        return $this->orderItems()->sum('quantity');
    }

    /**
     * Scope for authenticated user's orders
     */
    public function scopeForUser($query, $user = null)
    {
        return $query->where('user_id', $user ? $user->id : auth()->id());
    }

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    public function markAsPaid($stripePaymentId)
    {
        $this->update([
            'status' => self::STATUS_PAID,
            'stripe_payment_id' => $stripePaymentId
        ]);
    }

    public function markAsFailed()
    {
        $this->update(['status' => self::STATUS_FAILED]);
    }
}
