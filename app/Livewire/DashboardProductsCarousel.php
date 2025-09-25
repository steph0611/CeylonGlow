<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class DashboardProductsCarousel extends Component
{
    public $currentSlide = 0;
    public $totalSlides = 0;
    public $products;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::orderBy('created_at', 'desc')->get();
        $this->totalSlides = max(1, ceil($this->products->count() / 4));
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
        return view('livewire.dashboard-products-carousel');
    }
}
