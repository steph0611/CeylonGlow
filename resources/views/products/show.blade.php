<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - {{ $product->name }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="py-12">
        <div class="max-w-5xl mx-auto px-4">
            <a href="{{ route('products.index') }}" class="text-sm text-[#506c2a]">&larr; Back to products</a>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-xl shadow p-6">
                <div>
                    @if(!empty($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded">
                    @else
                        <img src="{{ asset('images/service-1.jpg') }}" alt="No image" class="w-full h-96 object-cover rounded">
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                    <div class="text-xl text-[#506c2a] font-semibold mb-4">${{ number_format($product->price, 2) }}</div>
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-2">Description</h2>
                        <p class="text-gray-700 whitespace-pre-line">{{ $product->description ?: 'No description available.' }}</p>
                    </div>
                    @php $qty = (int)($product->qty ?? 0); @endphp
                    <div class="mb-6 text-sm">
                        @if($qty === 0)
                            <span class="text-red-600">Out of stock</span>
                        @elseif($qty > 0 && $qty < 5)
                            <span class="text-amber-600">Low stock: {{ $product->qty }}</span>
                        @else
                            <span class="text-gray-600">In stock: {{ $product->qty }}</span>
                        @endif
                    </div>
                    
                    @if($qty > 0)
                        @auth
                            <div x-data="{ quantity: 1, maxQuantity: {{ $qty }}, totalPrice: {{ $product->price }} }" x-init="$watch('quantity', value => totalPrice = (value * {{ $product->price }}).toFixed(2))">
                                <!-- Quantity Selector -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                    <div class="flex items-center space-x-3">
                                        <button @click="if(quantity > 1) quantity--" type="button" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input x-model="quantity" type="number" min="1" :max="maxQuantity" class="w-16 text-center border border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-[#506c2a] focus:border-transparent">
                                        <button @click="if(quantity < maxQuantity) quantity++" type="button" class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Total: $<span x-text="totalPrice"></span></p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <!-- Add to Cart Button -->
                                    <form method="POST" action="{{ route('cart.add', $product->getKey()) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" :value="quantity">
                                        <button type="submit" class="w-full bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3e541f] transition-colors duration-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path>
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </form>

                                    <!-- Buy Now Button -->
                                    <form method="POST" action="{{ route('checkout.buy-now') }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" :value="quantity">
                                        <button type="submit" class="w-full bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-colors duration-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Buy Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="space-y-3">
                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                                    <p class="text-amber-800 text-sm">Please login to purchase this product</p>
                                </div>
                                <a href="{{ route('login') }}" class="inline-block bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3e541f] transition-colors duration-200">Login to Purchase</a>
                            </div>
                        @endauth
                    @else
                        <span class="inline-block bg-gray-300 text-gray-600 px-6 py-3 rounded-lg" aria-disabled="true">Out of Stock</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

</body>
</html>


