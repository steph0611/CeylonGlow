<?php

namespace App\Livewire;

use Livewire\Component;

class ContactFooter extends Component
{
    public $phone = '+7 (3519)580-111';
    public $address = 'City Center, Fashion Alley, Building 7';
    public $socialLinks = [
        ['icon' => 'bi-instagram', 'url' => '#'],
        ['icon' => 'bi-twitter', 'url' => '#'],
        ['icon' => 'bi-facebook', 'url' => '#']
    ];

    public function render()
    {
        return view('livewire.contact-footer');
    }
}
