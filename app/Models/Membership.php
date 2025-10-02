<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'memberships';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_months',
        'benefits',
        'is_active',
        'sort_order',
        'features',
        'discount_percentage',
        'max_uses_per_month',
    ];

    protected $casts = [
        'price' => 'float',
        'duration_months' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'benefits' => 'array',
        'features' => 'array',
        'discount_percentage' => 'float',
        'max_uses_per_month' => 'integer',
    ];

    /**
     * Get all membership subscriptions for this membership plan
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(MembershipSubscription::class, 'membership_id');
    }

    /**
     * Get active subscriptions for this membership plan
     */
    public function activeSubscriptions(): HasMany
    {
        return $this->hasMany(MembershipSubscription::class, 'membership_id')
                    ->where('status', 'active')
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope to get only active memberships
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get duration in human readable format
     */
    public function getDurationTextAttribute(): string
    {
        if ($this->duration_months == 1) {
            return '1 month';
        } elseif ($this->duration_months == 12) {
            return '1 year';
        } else {
            return $this->duration_months . ' months';
        }
    }
}
