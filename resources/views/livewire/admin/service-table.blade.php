<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <h2 class="text-lg font-semibold">All Services</h2>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search services..." class="w-full md:w-64 p-2 border rounded-lg" />
            <a href="{{ route('admin.services.create') }}" class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-xs hover:bg-gray-800">+ Add</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Image</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Duration</th>
                    <th class="p-3 text-left">Category</th>
                    <th class="p-3 text-left">Description</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" class="w-16 h-16 object-cover rounded-lg shadow-sm" alt="{{ $service->name }}">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gray-100 grid place-items-center text-gray-400 text-xs">No Image</div>
                            @endif
                        </td>
                        <td class="p-3 font-medium align-top">
                            <div>{{ $service->name }}</div>
                            <div class="text-xs text-gray-500">ID: {{ (string) $service->_id }}</div>
                        </td>
                        <td class="p-3 align-top">${{ number_format((float) $service->price, 2) }}</td>
                        <td class="p-3 align-top">{{ $service->duration }}</td>
                        <td class="p-3 align-top">{{ $service->category }}</td>
                        <td class="p-3 text-gray-600 align-top max-w-[360px]">
                            <div class="line-clamp-2">{{ $service->description }}</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.services.edit', $service->_id) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs hover:bg-blue-700">Edit</a>
                                <button wire:click="delete('{{ $service->_id }}')" class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs hover:bg-red-700">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">No services found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $services->links() }}</div>
</div>


