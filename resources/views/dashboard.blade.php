<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .hero-bg {background-image:url('{{ asset('images/hero-spa.jpg') }}');background-size:cover;background-position:center;}
        .section-card {background:#bfa38933;border-radius:14px}
        .btn-primary {background:#506c2a;color:#fff;padding:.75rem 1.5rem;border-radius:9999px}
        .btn-primary:hover {background:#3e541f}
        .muted {color:#6b7280}
    </style>
</head>
<body class="antialiased text-gray-900">

    {{-- Include Navigation --}}
    @include('navigation-menu')



    <section class="relative h-screen w-full overflow-hidden">
        <!-- Background video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('videos/hero-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Overlay for better text contrast -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- Content centered on screen -->
        <div class="relative z-10 h-full px-4">
            <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 max-w-xl text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 text-white">
                    A DIFFERENT<br>DIMENSION
                </h1>
                <p class="muted mb-8 text-gray-200 text-lg">
                    Here we care for your appearance, give strength to beauty and youth,
                    and help you find inner peace and clarity. We warmly welcome everyone
                    who wants to restore freshness and radiance to their skin.
                </p>
                <a href="#booking" class="btn-primary inline-block">BOOK ONLINE</a>
            </div>
        </div>
    </section>



    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="section-card p-8 md:p-10">
                <h2 class="text-center text-2xl font-semibold mb-8">Why Choose Us?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center text-sm">
                    <div>
                        <div class="text-4xl text-gray-400 mb-2">1</div>
                        <div class="font-semibold mb-1">Quality</div>
                        <p class="muted">Our space is filled with care: the latest treatments and the best international brands.</p>
                    </div>
                    <div>
                        <div class="text-4xl text-gray-400 mb-2">2</div>
                        <div class="font-semibold mb-1">Safety</div>
                        <p class="muted">Strict adherence to standards and sterilization of instruments.</p>
                    </div>
                    <div>
                        <div class="text-4xl text-gray-400 mb-2">3</div>
                        <div class="font-semibold mb-1">Effectiveness</div>
                        <p class="muted">We are loved for visible results and carefully designed methods.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">Our Services</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services as $service)
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-40 object-cover" alt="{{ $service->name }}">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <div class="p-5">
                            <h3 class="font-semibold">{{ $service->name }}</h3>
                            <div class="text-[#506c2a] font-semibold mt-1">${{ $service->price }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $service->duration }} • {{ $service->category }}</div>
                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($service->description, 100) }}</p>
                            <a href="#booking" class="inline-block mt-3 bg-[#506c2a] text-white px-4 py-2 rounded-full text-sm hover:bg-[#3e541f] transition-colors">Book Now</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No services available at the moment.</n+p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('services') }}" class="btn-primary">ALL PROCEDURES</a>
            </div>
        </div>
    </section>

    <section id="offers" class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-xl md:text-2xl font-semibold mb-6">Special Offers</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                <div class="relative">
                    <img src="{{ asset('images/offer-1.png') }}" class="w-full h-64 object-cover rounded" alt="Offer 1">
                    <div class="absolute left-4 bottom-4 bg-white/90 rounded px-4 py-2 text-sm"><span class="font-semibold">30%</span> off facial massage with body wrap</div>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <img src="{{ asset('images/offer-2.png') }}" class="w-full h-28 object-cover rounded" alt="Offer 2">
                    <img src="{{ asset('images/offer-3.png') }}" class="w-full h-28 object-cover rounded" alt="Offer 3">
                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">Featured Products</h3>
            
            <!-- Products Carousel -->
            <div class="relative overflow-hidden">
                <div id="productsCarousel" class="flex transition-transform duration-500 ease-in-out">
                    @foreach($products as $product)
                        <div class="w-full md:w-1/2 lg:w-1/4 flex-shrink-0 px-2">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover" alt="{{ $product->name }}">
                                @else
                                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h4 class="font-semibold text-sm mb-1">{{ $product->name }}</h4>
                                    <p class="text-xs text-gray-600 mb-2">{{ Str::limit($product->description, 60) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[#506c2a] font-bold">${{ $product->price }}</span>
                                        <span class="text-xs text-gray-500">Qty: {{ $product->qty }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Carousel Navigation -->
                <button id="prevBtn" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button id="nextBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Carousel Indicators -->
            <div class="flex justify-center mt-4 space-x-2">
                @for($i = 0; $i < ceil($products->count() / 4); $i++)
                    <button class="carousel-indicator w-2 h-2 rounded-full bg-gray-300 transition-colors" data-slide="{{ $i }}"></button>
                @endfor
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}" class="btn-primary">VIEW ALL PRODUCTS</a>
            </div>
        </div>
    </section>

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

    <script>
        // Products Carousel Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('productsCarousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.querySelectorAll('.carousel-indicator');
            
            let currentSlide = 0;
            const totalSlides = Math.ceil({{ $products->count() }} / 4);
            
            function updateCarousel() {
                const translateX = -currentSlide * 100;
                carousel.style.transform = `translateX(${translateX}%)`;
                
                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentSlide) {
                        indicator.classList.add('bg-[#506c2a]');
                        indicator.classList.remove('bg-gray-300');
                    } else {
                        indicator.classList.remove('bg-[#506c2a]');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel();
            }
            
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }
            
            // Event listeners
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);
            
            // Indicator clicks
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentSlide = index;
                    updateCarousel();
                });
            });
            
            // Auto-advance carousel every 5 seconds
            setInterval(nextSlide, 5000);
            
            // Initialize carousel
            updateCarousel();
        });
    </script>
</body>
</html>
