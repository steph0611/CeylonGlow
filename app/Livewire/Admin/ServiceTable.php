<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceTable extends Component
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
        Service::query()->where('_id', $id)->delete();
        $this->dispatch('toast', message: 'Service deleted');
    }

    public function getServicesProperty()
    {
        return Service::query()
            ->when($this->search !== '', function (Builder $query) {
                $q = $this->search;
                $query->where(function (Builder $sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.service-table', [
            'services' => $this->services,
        ]);
    }
}


