<div>
    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    @if(empty($cart))
        <p class="text-gray-600">Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-[#506c2a] text-white px-6 py-3 rounded-full">Continue Shopping</a>
    @else
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-3 flex items-center gap-3 border-b">
                <div class="flex gap-2">
                    <button wire:click="selectAll" class="text-sm text-blue-600 hover:underline">Select All</button>
                    <button wire:click="clearSelection" class="text-sm text-gray-600 hover:underline">Clear Selection</button>
                </div>
                <div class="ms-auto text-gray-700">Subtotal: <span class="text-xl font-bold text-[#506c2a]">${{ number_format($total, 2) }}</span></div>
            </div>
            <div class="divide-y">
                @foreach($cart as $key => $item)
                    <div class="p-4 flex items-center gap-4">
                        <input type="checkbox" 
                               wire:click="toggleSelect('{{ $key }}')" 
                               @if(in_array($key, $selected)) checked @endif
                               class="w-4 h-4 text-[#506c2a] border-gray-300 rounded focus:ring-[#506c2a]">
                        <img src="{{ $item['image'] ?? asset('images/service-1.jpg') }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded">
                        <div class="flex-1">
                            <div class="font-semibold">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</div>
                        </div>
                        <div class="text-[#506c2a] font-semibold w-28 text-right">${{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2) }}</div>
                        <button wire:click="remove('{{ $key }}')" class="text-red-600 hover:underline">Remove</button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('products.index') }}" class="px-5 py-3 rounded-full border border-gray-300 hover:bg-gray-50 transition-colors">Continue Shopping</a>
            <form method="POST" action="{{ route('checkout.cart') }}">
                @csrf
                <button type="submit" class="px-5 py-3 rounded-full bg-[#506c2a] text-white hover:bg-[#3e541f] transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Proceed to Checkout {{ count($selected) > 0 ? '(' . count($selected) . ' items)' : 'All Items' }}
                </button>
            </form>
        </div>
    @endif
</div>


