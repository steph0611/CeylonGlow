<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\On;

class DashboardServicesCarousel extends Component
{
    public $currentSlide = 0;
    public $totalSlides = 0;
    public $services;

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = Service::orderBy('created_at', 'desc')->get();
        $this->totalSlides = max(1, ceil($this->services->count() / 3));
    }

    #[On('nextSlide')]
    public function nextSlide()
    {
        if ($this->totalSlides > 1) {
            $this->currentSlide = ($this->currentSlide + 1) % $this->totalSlides;
        }
    }

    public function prevSlide()
    {
        if ($this->totalSlides > 1) {
            $this->currentSlide = ($this->currentSlide - 1 + $this->totalSlides) % $this->totalSlides;
        }
    }

    public function goToSlide($slide)
    {
        $this->currentSlide = $slide;
    }

    public function render()
    {
        return view('livewire.dashboard-services-carousel');
    }
}
