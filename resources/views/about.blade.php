<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <!-- Hero -->
    <section class="relative w-full overflow-hidden h-[320px] md:h-[420px]">
        <img src="{{ asset('images/service-3.jpg') }}" class="w-full h-full object-cover" alt="About">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/40 to-black/30"></div>
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-6xl mx-auto px-6">
                <h1 class="text-3xl md:text-5xl font-extrabold text-white drop-shadow">About Ceylon Glow</h1>
                <p class="mt-3 md:mt-4 max-w-2xl text-gray-200">Professional beauty and wellness, curated with science and care—delivered online and in studio.</p>
            </div>
        </div>
        <!-- Decorative circles -->
        <div class="absolute -right-16 -bottom-16 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -left-20 -top-20 h-56 w-56 rounded-full bg-emerald-200/10 blur-2xl"></div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-6 space-y-12">
            <!-- Story Split Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="relative order-2 md:order-1">
                    <div class="absolute -left-6 -top-6 h-24 w-24 rounded-xl bg-emerald-100/60"></div>
                    <img src="{{ asset('images/service-1.jpg') }}" class="relative w-full h-72 md:h-80 object-cover rounded-2xl shadow-md" alt="Studio">
                </div>
                <div class="order-1 md:order-2">
                    <h2 class="text-2xl font-bold">Our Story</h2>
                    <p class="mt-3 text-gray-700 leading-relaxed">Ceylon Glow is dedicated to professional beauty and wellness. We carefully curate products and treatments that deliver visible results while being gentle and safe for all skin types.</p>
                    <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                        <div class="bg-white rounded-xl shadow p-4">
                            <div class="text-[#506c2a] text-xl font-bold">5+</div>
                            <div class="text-xs text-gray-500">Years</div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-4">
                            <div class="text-[#506c2a] text-xl font-bold">10k</div>
                            <div class="text-xs text-gray-500">Clients</div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-4">
                            <div class="text-[#506c2a] text-xl font-bold">50+</div>
                            <div class="text-xs text-gray-500">Brands</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promise Split Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-2xl font-bold">Our Promise</h2>
                    <p class="mt-3 text-gray-700 leading-relaxed">Quality, transparency, and care. We partner with trusted brands and licensed professionals to bring you the best experience online and in-store.</p>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach([
                            ['Safe & Gentle','Mild on all skin types'],
                            ['Science-led','Evidence-based selection'],
                            ['Sustainable','Responsible sourcing']
                        ] as $item)
                            <div class="bg-white rounded-xl shadow p-4">
                                <div class="font-semibold">{{ $item[0] }}</div>
                                <div class="text-xs text-gray-600">{{ $item[1] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-xl bg-emerald-100/60"></div>
                    <img src="{{ asset('images/service-2.jpg') }}" class="relative w-full h-72 md:h-80 object-cover rounded-2xl shadow-md" alt="Promise">
                </div>
            </div>

            <!-- Mission / Vision / Values with Icons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['Mission','Empower people to look and feel their best with safe, effective care.'],
                    ['Vision','Be the most trusted destination for beauty, self-care, and wellbeing.'],
                    ['Values','Integrity, results, inclusivity, and kindness in everything we do.']
                ] as $block)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="h-10 w-10 rounded-lg bg-[#506c2a] text-white grid place-items-center text-sm">★</div>
                        <h3 class="mt-3 font-semibold">{{ $block[0] }}</h3>
                        <p class="text-sm text-gray-700 mt-1">{{ $block[1] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-semibold mb-4">Our Journey</h3>
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    <div class="space-y-6">
                        @foreach([
                            ['2019','Founded with a simple studio and curated products.'],
                            ['2021','Expanded services and introduced memberships.'],
                            ['2023','Launched our online experience and delivery.'],
                            ['Today','Serving a growing community with expert care.']
                        ] as $row)
                            <div class="pl-10">
                                <div class="relative">
                                    <div class="absolute -left-6 top-1.5 h-3 w-3 rounded-full bg-[#506c2a]"></div>
                                    <div class="text-sm text-gray-500">{{ $row[0] }}</div>
                                    <div class="font-medium">{{ $row[1] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Team -->
            <div class="">
                <h3 class="font-semibold mb-4">Meet the Team</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach([
                        ['Ava','Senior Specialist','service-4.jpg'],
                        ['Noah','Dermal Therapist','service-5.jpg'],
                        ['Mia','Esthetician','service-3.jpg'],
                        ['Liam','Consultant','service-1.jpg']
                    ] as $member)
                        <div class="bg-white rounded-2xl shadow overflow-hidden">
                            <div class="h-28 bg-gradient-to-r from-emerald-200 to-emerald-100"></div>
                            <div class="-mt-10 px-5 pb-5 text-center">
                                <img src="{{ asset('images/' . $member[2]) }}" class="mx-auto h-20 w-20 rounded-full object-cover ring-4 ring-white shadow" alt="{{ $member[0] }}">
                                <div class="mt-2 font-medium">{{ $member[0] }}</div>
                                <div class="text-xs text-gray-500">{{ $member[1] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- FAQ -->
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-semibold mb-3">FAQ</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <div class="font-medium">Are your products cruelty-free?</div>
                        <p class="text-gray-700">Yes, we prioritize ethical sourcing and cruelty-free brands.</p>
                    </div>
                    <div>
                        <div class="font-medium">Do you offer consultations?</div>
                        <p class="text-gray-700">Book a consultation via our booking link for personalized advice.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>


