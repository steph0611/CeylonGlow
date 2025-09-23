<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceGrid extends Component
{
    use WithPagination;

    public function getServicesProperty()
    {
        return Service::query()
            ->orderBy('created_at', 'desc')
            ->paginate(9);
    }

    public function render()
    {
        return view('livewire.service-grid', [
            'services' => $this->services,
        ]);
    }
}


