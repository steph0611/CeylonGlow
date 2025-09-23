<?php

namespace App\Livewire\Admin;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BannerManager extends Component
{
    use WithFileUploads;

    public $banner1;
    public $banner2;
    public $banner3;
    public $banner4;

    public function save(): void
    {
        $files = collect([
            'banner1' => $this->banner1,
            'banner2' => $this->banner2,
            'banner3' => $this->banner3,
            'banner4' => $this->banner4,
        ])->filter();

        foreach ($files as $key => $file) {
            $path = $file->store('banners', 'public');
            Banner::query()->updateOrCreate(
                ['slot' => $key],
                ['image' => Storage::disk('public')->url($path)]
            );
        }

        $this->reset(['banner1', 'banner2', 'banner3', 'banner4']);
        $this->dispatch('toast', message: 'Banners updated');
    }

    public function delete(string $id): void
    {
        Banner::query()->where('_id', $id)->delete();
        $this->dispatch('toast', message: 'Banner deleted');
    }

    public function render()
    {
        return view('livewire.admin.banner-manager', [
            'banners' => Banner::query()->orderBy('slot')->get(),
        ]);
    }
}


