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
        'duration_days',
        'benefits',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'float',
        'duration_days' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'benefits' => 'array',
    ];

    /**
     * Get all membership purchases for this membership plan
     */
    public function purchases()
    {
        return MembershipPurchase::where('membership_id', $this->_id)->get();
    }

    /**
     * Get active membership purchases for this plan
     */
    public function activePurchases()
    {
        return MembershipPurchase::where('membership_id', $this->_id)
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->get();
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
}
