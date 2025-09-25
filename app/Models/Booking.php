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

    // Relationship with Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
