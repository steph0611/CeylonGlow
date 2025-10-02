<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
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
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-contain block md:hidden">
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

    <section id="services" class="py-8">
        <div class="max-w-6xl mx-auto px-4">
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">What Do We Recommend This Fall?</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <img src="{{ asset('images/service-1.jpg') }}" class="w-full h-40 object-cover rounded" alt="Pedicure">
                <img src="{{ asset('images/service-2.jpg') }}" class="w-full h-40 object-cover rounded" alt="Epilation">
                <img src="{{ asset('images/service-3.jpg') }}" class="w-full h-40 object-cover rounded" alt="Body Massage">
                <img src="{{ asset('images/service-4.jpg') }}" class="w-full h-40 object-cover rounded" alt="Cosmetology">
                <img src="{{ asset('images/service-5.jpg') }}" class="w-full h-40 object-cover rounded" alt="Facial">
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center text-xs">
                <div>
                    <div class="font-semibold">Pedicure</div>
                    <div class="muted">Hardware pedicure Ceyhovi</div>
                </div>
                <div>
                    <div class="font-semibold">Epilation</div>
                    <div class="muted">Modern equipment</div>
                </div>
                <div>
                    <div class="font-semibold">Body Treatments</div>
                    <div class="muted">LPG body massage</div>
                </div>
                <div>
                    <div class="font-semibold">Cosmetology</div>
                    <div class="muted">Mesotherapy and cryotherapy</div>
                </div>
                <div>
                    <div class="font-semibold">Facial</div>
                    <div class="muted">Deep hydration and nourishment</div>
                </div>
                <div class="hidden md:block"></div>
            </div>
            <div class="text-center mt-6">
                <a href="#all" class="btn-primary">ALL PROCEDURES</a>
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
            <h3 class="text-center text-xl md:text-2xl font-semibold mb-6">The Art of Beauty & Health</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <img src="{{ asset('images/news-1.webp') }}" class="w-full h-40 object-cover rounded" alt="News 1">
                <img src="{{ asset('images/news-2.jpg') }}" class="w-full h-40 object-cover rounded" alt="News 2">
                <img src="{{ asset('images/news-3.png') }}" class="w-full h-40 object-cover rounded" alt="News 3">
                <img src="{{ asset('images/news-4.jpg') }}" class="w-full h-40 object-cover rounded" alt="News 4">
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-xs">
                <div>
                    <div class="font-semibold">NEW</div>
                    <div class="muted">Weekend treatments</div>
                </div>
                <div>
                    <div class="font-semibold">RECOMMENDED</div>
                    <div class="muted">Thalasso Bretagne body wrap</div>
                </div>
                <div>
                    <div class="font-semibold">COSMETICS</div>
                    <div class="muted">Juliette Armand advantages</div>
                </div>
                <div>
                    <div class="font-semibold">ANTI-AGE</div>
                    <div class="muted">Skin aging solutions</div>
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="#news" class="btn-primary">ALL NEWS</a>
            </div>
        </div>
    </section>

    {{-- Include Professional Footer --}}
    @include('footer')
</body>
</html>

