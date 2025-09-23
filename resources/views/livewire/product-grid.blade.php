<div wire:poll.5s>
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold">Shop Our Products</h2>
            <input type="text" wire:model.debounce.300ms="search" placeholder="Search products..." class="p-2 border rounded-lg w-64">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @forelse($products as $product)
                @php
                    $imageUrl = !empty($product->image)
                        ? asset('storage/' . $product->image)
                        : asset('images/service-1.jpg');
                    $qty = (int) ($product->qty ?? 0);
                @endphp
                <div class="bg-white section-card shadow overflow-hidden flex flex-col group transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg w-full">
                    <div class="relative">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-56 object-cover rounded-t">
                        @if($qty === 0)
                            <span class="absolute top-3 left-3 bg-red-600 text-white text-xs px-2 py-1 rounded">Out of stock</span>
                        @elseif($qty > 0 && $qty < 5)
                            <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs px-2 py-1 rounded">Low stock</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-1">{{ $product->name }}</h3>
                        <p class="text-[#506c2a] font-bold">${{ number_format($product->price, 2) }}</p>
                        @if($qty > 0)
                            <a href="#booking" class="btn-primary mt-3 inline-block">Order Now</a>
                        @else
                            <span class="mt-3 inline-block bg-gray-300 text-gray-600 px-6 py-3 rounded-full cursor-not-allowed" aria-disabled="true">Out of Stock</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center muted mt-6 col-span-full">No products found.</p>
            @endforelse
        </div>

        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</div>


