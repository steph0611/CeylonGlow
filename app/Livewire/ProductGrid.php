<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGrid extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getProductsProperty()
    {
        return Product::query()
            ->when($this->search !== '', function (Builder $query) {
                $q = $this->search;
                $query->where(function (Builder $sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.product-grid', [
            'products' => $this->products,
        ]);
    }
}


