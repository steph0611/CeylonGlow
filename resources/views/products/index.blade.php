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
            <h3 class="text-xl md:text-2xl font-semibold mb-6">Special Prodsdfsdfsdfsddfuct Offers</h3>
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
                                <span class="text-red-600">Out of stock</span>
                            </template>
                            <template x-if="selected && Number(selected.qty) > 0 && Number(selected.qty) < 5">
                                <span class="text-amber-600">Low stock: <span x-text="selected.qty"></span></span>
                            </template>
                            <template x-if="selected && Number(selected.qty) >= 5">
                                <span class="text-gray-600">In stock: <span x-text="selected.qty"></span></span>
                            </template>
                        </div>

                        <div class="mt-6">
                            <template x-if="selected && Number(selected.qty) > 0">
                                <a href="#booking" class="inline-block bg-[#506c2a] text-white px-6 py-3 rounded-full">Order Now</a>
                            </template>
                            <template x-if="!selected || Number(selected.qty) === 0">
                                <span class="inline-block bg-gray-300 text-gray-600 px-6 py-3 rounded-full" aria-disabled="true">Out of Stock</span>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
