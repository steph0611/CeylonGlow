<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <h2 class="text-lg font-semibold">All Products</h2>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search products..." class="w-full md:w-64 p-2 border rounded-lg" />
            <a href="{{ route('admin.products.create') }}" class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-xs hover:bg-gray-800">+ Add</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Image</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Qty</th>
                    <th class="p-3 text-left">Description</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    @php $qty = (int) ($product->qty ?? 0); @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 object-cover rounded-lg shadow-sm" alt="{{ $product->name }}">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gray-100 grid place-items-center text-gray-400 text-xs">No Image</div>
                            @endif
                        </td>
                        <td class="p-3 font-medium align-top">
                            <div>{{ $product->name }}</div>
                            <div class="text-xs text-gray-500">ID: {{ (string) $product->_id }}</div>
                        </td>
                        <td class="p-3 align-top">${{ number_format((float) $product->price, 2) }}</td>
                        <td class="p-3 align-top">
                            @if($qty === 0)
                                <span class="inline-block px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">Out</span>
                            @elseif($qty > 0 && $qty < 5)
                                <span class="inline-block px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-700">Low ({{ $qty }})</span>
                            @else
                                <span class="inline-block px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-700">{{ $qty }}</span>
                            @endif
                        </td>
                        <td class="p-3 text-gray-600 align-top max-w-[360px]">
                            <div class="line-clamp-2">{{ $product->description }}</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->_id) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white text-xs hover:bg-blue-700">Edit</a>
                                <button wire:click="delete('{{ $product->_id }}')" class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-xs hover:bg-red-700">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>


