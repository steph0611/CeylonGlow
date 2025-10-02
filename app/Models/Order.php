<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'customer',
        'items',
        'total',
        'status',
        'placed_at',
        'notes',
        'shipping_address',
        'billing_address',
        'payment_method',
        'order_type',
        'membership_id'
    ];

    protected $casts = [
        'customer' => 'array',
        'items' => 'array',
        'total' => 'float',
        'placed_at' => 'datetime',
        'shipping_address' => 'array'
    ];

    // Accessor for customer name
    public function getCustomerNameAttribute()
    {
        return $this->customer['name'] ?? 'Guest';
    }

    // Accessor for customer email
    public function getCustomerEmailAttribute()
    {
        return $this->customer['email'] ?? null;
    }

    // Accessor for customer ID
    public function getCustomerIdAttribute()
    {
        return $this->customer['id'] ?? null;
    }

    // Scope for pending orders
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for completed orders
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope for cancelled orders
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Scope for membership orders
    public function scopeMembership($query)
    {
        return $query->where('order_type', 'membership');
    }

    // Scope for product orders
    public function scopeProduct($query)
    {
        return $query->where('order_type', 'product');
    }

    /**
     * Get membership subscriptions created from this order
     */
    public function membershipSubscriptions(): HasMany
    {
        return $this->hasMany(MembershipSubscription::class, 'order_id');
    }

    /**
     * Check if this is a membership order
     */
    public function isMembershipOrder(): bool
    {
        return $this->order_type === 'membership';
    }

    /**
     * Check if this is a product order
     */
    public function isProductOrder(): bool
    {
        return $this->order_type === 'product';
    }
}
