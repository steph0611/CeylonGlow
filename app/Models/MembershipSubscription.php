<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class MembershipSubscription extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'membership_subscriptions';

    protected $fillable = [
        'user_id',
        'membership_id',
        'status',
        'started_at',
        'expires_at',
        'payment_method',
        'amount_paid',
        'order_id',
        'auto_renew',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'amount_paid' => 'float',
        'auto_renew' => 'boolean',
    ];

    /**
     * Get the user who owns this subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the membership plan for this subscription
     */
    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    /**
     * Get the order associated with this subscription
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Scope to get only active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope to get only expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    /**
     * Scope to get only cancelled subscriptions
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at <= now();
    }

    /**
     * Check if subscription is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
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

    /**
     * Cancel the subscription
     */
    public function cancel(string $reason = null): bool
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);

        return true;
    }

    /**
     * Renew the subscription
     */
    public function renew(): bool
    {
        if (!$this->membership) {
            return false;
        }

        $newExpiryDate = $this->expires_at->addMonths($this->membership->duration_months);
        
        $this->update([
            'expires_at' => $newExpiryDate,
            'status' => 'active',
        ]);

        return true;
    }
}
