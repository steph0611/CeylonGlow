<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = ['name', 'price', 'description', 'qty', 'image'];

    protected $casts = [
        'price' => 'float',
        'qty' => 'integer',
    ];

    /**
     * Get all orders that contain this product
     */
    public function orders()
    {
        return Order::where('items.product_id', $this->_id)->get();
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        return $this->qty > 0;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Scope for in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('qty', '>', 0);
    }
}
