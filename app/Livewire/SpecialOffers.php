<?php

namespace App\Livewire;

use Livewire\Component;

class SpecialOffers extends Component
{
    public $offers = [
        [
            'image' => 'images/offer-1.png',
            'title' => '30% off facial massage with body wrap',
            'position' => 'large'
        ],
        [
            'image' => 'images/offer-2.png',
            'title' => 'Special Offer 2',
            'position' => 'small'
        ],
        [
            'image' => 'images/offer-3.png',
            'title' => 'Special Offer 3',
            'position' => 'small'
        ]
    ];

    public function render()
    {
        return view('livewire.special-offers');
    }
}
