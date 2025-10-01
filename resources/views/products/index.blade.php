<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Products</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    @livewireStyles
    <style>
        .hero-bg {background-image:url('{{ asset('images/service-5.jpg') }}');background-size:cover;background-position:center;}
        .section-card {background:#bfa38933;border-radius:14px}
        .btn-primary {background:#506c2a;color:#fff;padding:.75rem 1.5rem;border-radius:9999px;text-decoration:none;}
        .btn-primary:hover {background:#3e541f}
        .muted {color:#6b7280}
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50" x-data="{ open: false, selected: null }">

    {{-- Include Navigation --}}
    @include('navigation-menu')

    <div :class="open ? 'blur-sm' : ''">

    <!-- Hero Section with Banners Carousel -->
    <section class="relative w-full overflow-hidden">
        @php $bannerCount = isset($banners) ? $banners->count() : 0; @endphp

        @if($bannerCount > 0)
            <div 
                x-data="{
                    active: 0,
                    total: {{ $bannerCount }},
                    intervalId: null,
                    next(){ this.active = (this.active + 1) % this.total },
                    prev(){ this.active = (this.active - 1 + this.total) % this.total },
                    go(i){ this.active = i },
                    start(){ this.intervalId = setInterval(() => this.next(), 5000) },
                    stop(){ if(this.intervalId) clearInterval(this.intervalId) }
                }"
                x-init="start()"
                @mouseenter="stop()" 
                @mouseleave="start()"
                class="relative h-[60vh] md:h-[70vh]"
            >
                <!-- Slides -->
                <template x-for="(banner, i) in {{ $banners->toJson() }}" :key="i">
                    <div 
                        x-show="active === i" 
                        x-transition:enter="transition ease-out duration-700" 
                        x-transition:enter-start="opacity-0 scale-105" 
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute inset-0"
                    >
                        <img :src="banner.image" alt="Banner" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                    </div>
                </template>

                <!-- Centered Text -->
                <div class="relative z-10 h-full flex items-center justify-center text-center px-4">
                    <div class="max-w-2xl text-white">
                        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Our Products</h1>
                        <p class="mb-6 text-lg md:text-xl">Discover professional beauty & care products, handpicked for visible results and your comfort.</p>
                        <a href="#booking" class="btn-primary inline-block">BOOK ONLINE</a>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button 
                    @click="prev()" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-3 transition"
                >
                    ‹
                </button>
                <button 
                    @click="next()" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-3 transition"
                >
                    ›
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-6 left-0 right-0 flex items-center justify-center gap-3 z-10">
                    @foreach($banners as $index => $b)
                        <button 
                            class="w-3 h-3 rounded-full bg-white/50 transition-all duration-300"
                            :class="{ 'w-6 bg-white': active === {{ $index }} }"
                            @click="go({{ $index }})"
                        ></button>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Fallback if no banners -->
            <div class="relative h-[60vh] w-full overflow-hidden">
                <div class="hero-bg absolute inset-0 w-full h-full"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                <div class="relative z-10 h-full flex items-center justify-center px-4">
                    <div class="max-w-xl text-center">
                        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-white">Our Products</h1>
                        <p class="muted mb-6 text-gray-200 text-lg">
                            Discover professional beauty & care products, handpicked for visible results and your comfort.
                        </p>
                        <a href="#booking" class="btn-primary inline-block">BOOK ONLINE</a>
                    </div>
                </div>
            </div>
        @endif
    </section>


    <!-- Why Choose Our Products -->
    <section class="py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="section-card p-8 md:p-10">
                <h2 class="text-center text-2xl font-semibold mb-8">Why Choose Our Collection?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center text-sm">
                    <div>
                        <div class="text-4xl text-gray-400 mb-2">1</div>
                        <div class="font-semibold mb-1">Top Brands</div>
                        <p class="muted">World-renowned products for safety, quality, and effectiveness.</p>
                    </div>
                    <div>
                        <div class="text-4xl text-gray-400 mb-2">2</div>
                        <div class="font-semibold mb-1">Expert Selection</div>
                        <p class="muted">Chosen by professionals for visible results and gentle care.</p>
                    </div>
                    <div>
                        <div class="text-4xl text-gray-400 mb-2">3</div>
                        <div class="font-semibold mb-1">For Every Need</div>
                        <p class="muted">Solutions for skin, hair, and body, tailored for different lifestyles.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid (Livewire) -->
    <section class="py-12">
        <livewire:product-grid />
    </section>

    <!-- Recommended / Featured Types -->
    <section class="py-8">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">Recommended This Season</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                @foreach(['service-1.jpg','service-2.jpg','service-3.jpg','service-4.jpg','service-5.jpg'] as $img)
                    <img src="{{ asset('images/' . $img) }}" class="w-full h-36 object-cover rounded" alt="Product Type">
                @endforeach
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center text-xs">
                <div class="font-semibold">Serums</div>
                <div class="font-semibold">Creams</div>
                <div class="font-semibold">Masks</div>
                <div class="font-semibold">Oils</div>
                <div class="font-semibold">Peels</div>
            </div>
            <div class="text-center mt-6">
                <a href="#booking" class="btn-primary transition-colors">ALL PRODUCTS</a>
            </div>
        </div>
    </section>

    <!-- Special Offers -->
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-xl md:text-2xl font-semibold mb-6">Special Product Offers</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                <div class="relative">
                    <img src="{{ asset('images/offer-1.png') }}" class="w-full h-64 object-cover rounded" alt="Product Offer 1">
                    <div class="absolute left-4 bottom-4 bg-white/90 rounded px-4 py-2 text-sm"><span class="font-semibold">15%</span> off on selected serums</div>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <img src="{{ asset('images/offer-2.png') }}" class="w-full h-28 object-cover rounded" alt="Product Offer 2">
                    <img src="{{ asset('images/offer-3.png') }}" class="w-full h-28 object-cover rounded" alt="Product Offer 3">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contacts" class="bg-[#e7dfd7] py-8 mt-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <a href="#booking" class="btn-primary inline-block">BOOK ONLINE</a>
                <div class="text-center md:text-right">
                    <div class="font-semibold">+7 (3519)580-111</div>
                    <div class="muted text-xs">City Center, Fashion Alley, Building 7</div>
                </div>
            </div>
            <div class="flex items-center gap-4 justify-center md:justify-end mt-6 text-gray-600">
                <span class="i bi-instagram"></span>
                <span class="i bi-twitter"></span>
                <span class="i bi-facebook"></span>
            </div>
        </div>
    </footer>

    </div>

    <!-- Product Details Modal -->
    <div 
        x-show="open" 
        x-transition.opacity 
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        aria-modal="true" role="dialog"
    >
        <div 
            class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            @click="open = false; selected = null"
        ></div>

        <div 
            class="relative z-10 w-full max-w-3xl"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="bg-gray-50">
                        <template x-if="selected && selected.image">
                            <img :src="selected.image" :alt="selected.name" class="w-full h-72 md:h-full object-cover">
                        </template>
                        <template x-if="!selected || !selected.image">
                            <img src="{{ asset('images/service-1.jpg') }}" alt="No image" class="w-full h-72 md:h-full object-cover">
                        </template>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold" x-text="selected?.name || ''"></h2>
                                <div class="text-[#506c2a] font-semibold text-lg mt-1">
                                    <span x-text="selected ? `$${Number(selected.price).toFixed(2)}` : ''"></span>
                                </div>
                            </div>
                            <button class="text-gray-500 hover:text-gray-700" @click="open = false; selected = null" aria-label="Close">✕</button>
                        </div>

                        <p class="text-gray-700 mt-4" x-text="selected?.description || ''"></p>

                        <div class="mt-4 text-sm">
                            <template x-if="selected && Number(selected.qty) === 0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Out of stock
                                </span>
                            </template>
                            <template x-if="selected && Number(selected.qty) > 0 && Number(selected.qty) < 5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Low stock: <span x-text="selected.qty"></span> left
                                </span>
                            </template>
                            <template x-if="selected && Number(selected.qty) >= 5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    In stock: <span x-text="selected.qty"></span> available
                                </span>
                            </template>
                        </div>

                        <!-- Quantity Selector and Purchase Options -->
                        <template x-if="selected && Number(selected.qty) > 0">
                            <div class="mt-6" x-data="{ 
                                quantity: 1, 
                                maxQuantity: Number(selected?.qty || 0), 
                                totalPrice: Number(selected?.price || 0),
                                updateTotal() {
                                    this.totalPrice = (this.quantity * Number(selected?.price || 0)).toFixed(2);
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
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <!-- Add to Cart Button -->
                                    <form method="POST" :action="`/cart/add/${selected.id}`" class="flex-1">
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
                                        <input type="hidden" name="product_id" :value="selected.id">
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
                        </template>

                        <!-- Out of Stock Message -->
                        <template x-if="!selected || Number(selected?.qty || 0) === 0">
                            <div class="mt-6 text-center py-6">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-gray-500 font-medium">This product is currently out of stock</p>
                                <p class="text-sm text-gray-400 mt-1">Please check back later or contact us for availability</p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
