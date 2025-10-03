<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bookings';

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'service_id',
        'service_name',
        'service_price',
        'booking_date',
        'booking_time',
        'status',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
        'service_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the service for this booking
     */
    public function service()
    {
        return Service::find($this->service_id);
    }

    /**
     * Get the user who made this booking (cross-database relationship)
     */
    public function user()
    {
        return \App\Models\User::where('email', $this->customer_email)->first();
    }

    /**
     * Check if booking is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Check if booking is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if booking is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Scope for active bookings
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * Scope for completed bookings
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
