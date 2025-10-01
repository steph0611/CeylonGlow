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
        <!-- Desktop Background video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover hidden md:block">
            <source src="{{ asset('videos/hero-video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <!-- Mobile Background video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover block md:hidden">
            <source src="{{ asset('videos/mobilehero.mp4') }}" type="video/mp4">
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
            @livewire('why-choose-us')
        </div>
    </section>

    <section id="services" class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">Our Services</h3>
            
            <!-- Services Carousel - Livewire Component -->
            @livewire('dashboard-services-carousel')
            
            <div class="text-center mt-8">
                <a href="{{ route('services') }}" class="btn-primary">ALL PROCEDURES</a>
            </div>
        </div>
    </section>

    <section id="offers" class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-xl md:text-2xl font-semibold mb-6">Special Offers</h3>
            @livewire('special-offers')
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">Featured Products</h3>
            
            <!-- Products Carousel - Livewire Component -->
            @livewire('dashboard-products-carousel')
            
            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}" class="btn-primary">VIEW ALL PRODUCTS</a>
            </div>
        </div>
    </section>

    <footer id="contacts" class="bg-[#e7dfd7] py-8 mt-8">
        <div class="max-w-6xl mx-auto px-4">
            @livewire('contact-footer')
        </div>
    </footer>

    <script>
        // Auto-advance carousels functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-advance products carousel every 5 seconds
            setInterval(() => {
                Livewire.dispatch('nextSlide', {}, 'dashboard-products-carousel');
            }, 5000);
            
            // Auto-advance services carousel every 6 seconds
            setInterval(() => {
                Livewire.dispatch('nextSlide', {}, 'dashboard-services-carousel');
            }, 6000);
        });
    </script>
</body>
</html>
