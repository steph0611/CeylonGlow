<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get all membership purchases for this user
     */
    public function membershipPurchases(): HasMany
    {
        return $this->hasMany(MembershipPurchase::class, 'user_id');
    }

    /**
     * Get active membership purchase for this user
     */
    public function activeMembershipPurchase()
    {
        return $this->membershipPurchases()
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->with('membership')
                    ->first();
    }

    /**
     * Check if user has an active membership
     */
    public function hasActiveMembership(): bool
    {
        return $this->activeMembershipPurchase() !== null;
    }

    /**
     * Get the current active membership plan
     */
    public function getActiveMembership()
    {
        $purchase = $this->activeMembershipPurchase();
        return $purchase ? $purchase->membership : null;
    }
}
