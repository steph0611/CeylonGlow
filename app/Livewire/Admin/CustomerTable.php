<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
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
        Customer::query()->where('_id', $id)->delete();
        $this->dispatch('toast', message: 'Customer deleted successfully');
    }

    #[On('customer-created')]
    #[On('customer-updated')]
    public function refreshCustomers(): void
    {
        // Trigger re-render
    }

    public function getCustomersProperty()
    {
        return Customer::query()
            ->when($this->search !== '', function (Builder $query) {
                $q = $this->search;
                $query->where(function (Builder $sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhere('username', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.customer-table', [
            'customers' => $this->customers,
        ]);
    }
}
