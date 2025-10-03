<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Services - Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="relative w-full overflow-hidden h-64">
        <img src="{{ asset('images/service-5.jpg') }}" class="w-full h-full object-cover" alt="Services">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white">Our Services</h1>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 space-y-10">
            <div>
                <livewire:service-grid />
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Pricing</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between border-b pb-2">
                            <span>Glow Facial</span>
                            <span class="text-[#506c2a] font-semibold">$45</span>
                        </div>
                        <div class="flex items-center justify-between border-b pb-2">
                            <span>Hydration Boost</span>
                            <span class="text-[#506c2a] font-semibold">$60</span>
                        </div>
                        <div class="flex items-center justify-between border-b pb-2">
                            <span>Deep Cleanse</span>
                            <span class="text-[#506c2a] font-semibold">$50</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between border-b pb-2">
                            <span>Relaxing Massage</span>
                            <span class="text-[#506c2a] font-semibold">$40</span>
                        </div>
                        <div class="flex items-center justify-between border-b pb-2">
                            <span>Hair Treatment</span>
                            <span class="text-[#506c2a] font-semibold">$55</span>
                        </div>
                        <div class="flex items-center justify-between border-b pb-2">
                            <span>Body Polish</span>
                            <span class="text-[#506c2a] font-semibold">$65</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-3">FAQ</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="font-medium">How do I book a service?</div>
                        <p class="text-gray-700">Use the Book Now button or visit the booking section on our site.</p>
                    </div>
                    <div>
                        <div class="font-medium">Do you offer packages?</div>
                        <p class="text-gray-700">Yes, check our Memberships for bundled savings and perks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Include Professional Footer --}}
    @include('footer')

    @livewireScripts
</body>
</html>



