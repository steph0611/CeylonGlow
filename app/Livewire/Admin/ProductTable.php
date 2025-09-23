<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
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

    public function delete(string $id): void
    {
        Product::query()->where('_id', $id)->delete();
        $this->dispatch('toast', message: 'Product deleted');
    }

    #[On('product-created')]
    public function refreshProducts(): void
    {
        // Trigger re-render
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
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.product-table', [
            'products' => $this->products,
        ]);
    }
}


