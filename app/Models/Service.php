<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Service extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'services';

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'duration', 
        'image', 
        'category',
        'is_featured'
    ];

    protected $casts = [
        'price' => 'float',
        'duration' => 'integer',
        'is_featured' => 'boolean',
    ];

    /**
     * Get all bookings for this service
     */
    public function bookings()
    {
        return Booking::where('service_id', $this->_id)->get();
    }

    /**
     * Get active bookings for this service
     */
    public function activeBookings()
    {
        return Booking::where('service_id', $this->_id)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->get();
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Scope for featured services
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
