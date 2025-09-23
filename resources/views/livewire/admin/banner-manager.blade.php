<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-lg font-semibold mb-4">Manage Banners (Max 4)</h2>

    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="file" wire:model="banner1" class="p-2 border rounded-lg" accept="image/*">
        <input type="file" wire:model="banner2" class="p-2 border rounded-lg" accept="image/*">
        <input type="file" wire:model="banner3" class="p-2 border rounded-lg" accept="image/*">
        <input type="file" wire:model="banner4" class="p-2 border rounded-lg" accept="image/*">
        <button type="submit" class="px-3 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800 md:col-span-2">Upload / Update</button>
    </form>

    <div class="mt-6">
        <h3 class="text-md font-semibold mb-3">Active Banners</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($banners as $banner)
                @if($banner->image)
                    <div class="relative rounded-lg overflow-hidden shadow-sm">
                        <img src="{{ $banner->image }}" class="w-full h-40 object-cover" alt="Banner">
                        <button wire:click="delete('{{ $banner->_id }}')" class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">Delete</button>
                    </div>
                @endif
            @empty
                <p class="text-gray-500">No banners active.</p>
            @endforelse
        </div>
    </div>
</div>


