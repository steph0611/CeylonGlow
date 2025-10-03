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

    <section class="py-12 -mt-16 pt-16">
        <div class="max-w-5xl mx-auto px-4">
            <a href="{{ route('products.index') }}" class="text-sm text-[#506c2a] hover:text-[#3e541f] transition-colors">&larr; Back to products</a>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-xl shadow-lg p-6">
                <!-- Product Image -->
                <div>
                    @if(!empty($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg shadow-md">
                    @else
                        <img src="{{ asset('images/service-1.jpg') }}" alt="No image" class="w-full h-96 object-cover rounded-lg shadow-md">
                    @endif
                </div>
                
                <!-- Product Details -->
                <div>
                    <h1 class="text-3xl font-bold mb-2 text-gray-900">{{ $product->name }}</h1>
                    <div class="text-2xl text-[#506c2a] font-semibold mb-4">${{ number_format($product->price, 2) }}</div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2 text-gray-800">Description</h2>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $product->description ?: 'No description available.' }}</p>
                    </div>
                    
                    <!-- Stock Status -->
                    @php $qty = (int)($product->qty ?? 0); @endphp
                    <div class="mb-6">
                        @if($qty === 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Out of stock
                            </span>
                        @elseif($qty > 0 && $qty < 5)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Low stock: {{ $product->qty }} left
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                In stock: {{ $product->qty }} available
                            </span>
                        @endif
                    </div>
                    
                    @if($qty > 0)
                        @auth
                            <!-- Quantity Selector and Purchase Options -->
                            <div x-data="{ 
                                quantity: 1, 
                                maxQuantity: {{ $qty }}, 
                                totalPrice: {{ $product->price }},
                                updateTotal() {
                                    this.totalPrice = (this.quantity * {{ $product->price }}).toFixed(2);
                                }
                            }" x-init="updateTotal()">
                                
                                <!-- Quantity Selector -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Quantity</label>
                                    <div class="flex items-center space-x-3">
                                        <button @click="if(quantity > 1) { quantity--; updateTotal(); }" 
                                                type="button" 
                                                class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-50 hover:border-[#506c2a] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:ring-offset-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        
                                        <input x-model="quantity" 
                                               @input="updateTotal()"
                                               type="number" 
                                               min="1" 
                                               :max="maxQuantity" 
                                               class="w-20 text-center border-2 border-gray-300 rounded-lg py-2 focus:ring-2 focus:ring-[#506c2a] focus:border-transparent font-medium">
                                               
                                        <button @click="if(quantity < maxQuantity) { quantity++; updateTotal(); }" 
                                                type="button" 
                                                class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-50 hover:border-[#506c2a] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:ring-offset-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Total: <span class="font-semibold text-[#506c2a] text-lg">$<span x-text="totalPrice"></span></span>
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- Add to Cart Button -->
                                    <form method="POST" action="{{ route('cart.add', $product->getKey()) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="quantity" :value="quantity">
                                        <button type="submit" class="w-full bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3e541f] transition-all duration-200 flex items-center justify-center font-medium shadow-md hover:shadow-lg">
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
                                        <button type="submit" class="w-full bg-amber-600 text-white px-6 py-3 rounded-lg hover:bg-amber-700 transition-all duration-200 flex items-center justify-center font-medium shadow-md hover:shadow-lg">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Buy Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Guest User Message -->
                            <div class="space-y-4">
                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        <p class="text-amber-800 font-medium">Please login to purchase this product</p>
                                    </div>
                                </div>
                                <a href="{{ route('login') }}" class="inline-block bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3e541f] transition-colors duration-200 font-medium text-center w-full">
                                    Login to Purchase
                                </a>
                            </div>
                        @endauth
                    @else
                        <!-- Out of Stock -->
                        <div class="text-center py-6">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-gray-500 font-medium">This product is currently out of stock</p>
                            <p class="text-sm text-gray-400 mt-1">Please check back later or contact us for availability</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            {{ session('error') }}
        </div>
    @endif

</body>
</html>
