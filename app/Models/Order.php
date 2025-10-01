<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

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
        'payment_method'
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
}
