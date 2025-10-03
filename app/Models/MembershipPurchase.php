<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class MembershipPurchase extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'membership_purchases';

    protected $fillable = [
        'user_id',
        'membership_id',
        'status',
        'purchased_at',
        'expires_at',
        'payment_method',
        'amount_paid',
        'order_id',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'expires_at' => 'datetime',
        'amount_paid' => 'float',
    ];

    /**
     * Get the user who purchased this membership (cross-database relationship)
     */
    public function user()
    {
        return \App\Models\User::find($this->user_id);
    }

    /**
     * Get the membership plan for this purchase
     */
    public function membership()
    {
        return Membership::find($this->membership_id);
    }

    /**
     * Get the order associated with this purchase
     */
    public function order()
    {
        return Order::find($this->order_id);
    }

    /**
     * Scope to get only active memberships
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope to get only expired memberships
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Check if membership is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    /**
     * Check if membership is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at <= now();
    }

    /**
     * Get days remaining until expiration
     */
    public function getDaysRemainingAttribute(): int
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->expires_at);
    }

    /**
     * Get formatted amount paid
     */
    public function getFormattedAmountPaidAttribute(): string
    {
        return '$' . number_format($this->amount_paid, 2);
    }
}
