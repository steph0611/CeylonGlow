<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberships = [
            [
                'name' => 'Basic',
                'description' => 'Perfect for occasional visits and basic benefits',
                'price' => 29.00,
                'duration_months' => 1,
                'benefits' => [
                    'Member-only discounts (10%)',
                    'Priority booking',
                    'Birthday perk',
                    'Monthly newsletter'
                ],
                'features' => [
                    'Basic support',
                    'Standard booking window'
                ],
                'discount_percentage' => 10.0,
                'max_uses_per_month' => 5,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Plus',
                'description' => 'Extra perks and savings for regular visitors',
                'price' => 59.00,
                'duration_months' => 1,
                'benefits' => [
                    'Everything in Basic',
                    'Enhanced discounts (15%)',
                    'Quarterly freebies',
                    'Early access to new services',
                    'Priority customer support'
                ],
                'features' => [
                    'Enhanced support',
                    'Extended booking window',
                    'Free quarterly gift'
                ],
                'discount_percentage' => 15.0,
                'max_uses_per_month' => 10,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Pro',
                'description' => 'Best value for regulars with premium benefits',
                'price' => 99.00,
                'duration_months' => 1,
                'benefits' => [
                    'Everything in Plus',
                    'Maximum discounts (20%)',
                    'VIP support',
                    'Exclusive events access',
                    'Free monthly treatment',
                    'Personal beauty consultant'
                ],
                'features' => [
                    'VIP support',
                    'Unlimited booking window',
                    'Monthly free treatment',
                    'Personal consultant access'
                ],
                'discount_percentage' => 20.0,
                'max_uses_per_month' => null, // Unlimited
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Annual Basic',
                'description' => 'Yearly membership with 2 months free',
                'price' => 290.00,
                'duration_months' => 12,
                'benefits' => [
                    'Member-only discounts (10%)',
                    'Priority booking',
                    'Birthday perk',
                    'Monthly newsletter',
                    '2 months free (save $58)'
                ],
                'features' => [
                    'Basic support',
                    'Standard booking window',
                    'Annual savings'
                ],
                'discount_percentage' => 10.0,
                'max_uses_per_month' => 5,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Annual Pro',
                'description' => 'Premium yearly membership with maximum benefits',
                'price' => 990.00,
                'duration_months' => 12,
                'benefits' => [
                    'Everything in Pro',
                    'Maximum discounts (20%)',
                    'VIP support',
                    'Exclusive events access',
                    'Free monthly treatment',
                    'Personal beauty consultant',
                    '3 months free (save $297)'
                ],
                'features' => [
                    'VIP support',
                    'Unlimited booking window',
                    'Monthly free treatment',
                    'Personal consultant access',
                    'Annual savings'
                ],
                'discount_percentage' => 20.0,
                'max_uses_per_month' => null, // Unlimited
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($memberships as $membershipData) {
            Membership::create($membershipData);
        }
    }
}
