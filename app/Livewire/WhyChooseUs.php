<?php

namespace App\Livewire;

use Livewire\Component;

class WhyChooseUs extends Component
{
    public $features = [
        [
            'number' => '1',
            'title' => 'Quality',
            'description' => 'Our space is filled with care: the latest treatments and the best international brands.'
        ],
        [
            'number' => '2',
            'title' => 'Safety',
            'description' => 'Strict adherence to standards and sterilization of instruments.'
        ],
        [
            'number' => '3',
            'title' => 'Effectiveness',
            'description' => 'We are loved for visible results and carefully designed methods.'
        ]
    ];

    public function render()
    {
        return view('livewire.why-choose-us');
    }
}
