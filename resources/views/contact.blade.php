<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contact Us - Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="relative w-full overflow-hidden h-64 -mt-16 pt-16">
        <img src="{{ asset('images/news-3.png') }}" class="w-full h-full object-cover" alt="Contact">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white">Contact Us</h1>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-2">Book a Service</h2>
                    <p class="text-gray-600 text-sm mb-4">Ready to book? Fill out the form below and we'll get back to you to confirm your appointment.</p>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="text" name="customer_name" placeholder="Full name" value="{{ old('customer_name') }}" class="w-full p-2 border rounded-lg @error('customer_name') border-red-500 @enderror" required>
                        @error('customer_name')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <input type="email" name="customer_email" placeholder="Email" value="{{ old('customer_email') }}" class="w-full p-2 border rounded-lg @error('customer_email') border-red-500 @enderror" required>
                        @error('customer_email')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <input type="tel" name="customer_phone" placeholder="Phone number" value="{{ old('customer_phone') }}" class="w-full p-2 border rounded-lg @error('customer_phone') border-red-500 @enderror" required>
                        @error('customer_phone')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <select name="service_id" class="w-full p-2 border rounded-lg @error('service_id') border-red-500 @enderror" required>
                            <option value="">Select a service</option>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->_id }}" {{ (old('service_id') == $service->_id || request('service') == $service->_id) ? 'selected' : '' }}>
                                    {{ $service->name }} - ${{ $service->price }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <div class="grid grid-cols-2 gap-3">
                            <input type="date" name="booking_date" value="{{ old('booking_date') }}" class="p-2 border rounded-lg @error('booking_date') border-red-500 @enderror" required>
                            @error('booking_date')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror

                            <input type="time" name="booking_time" value="{{ old('booking_time') }}" class="p-2 border rounded-lg @error('booking_time') border-red-500 @enderror" required>
                            @error('booking_time')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <textarea name="notes" placeholder="Additional notes or special requests" rows="3" class="w-full p-2 border rounded-lg @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="bg-[#506c2a] text-white px-5 py-2.5 rounded-full hover:bg-[#3e541f] transition-colors">Book Now</button>
                    </form>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-2">Contact details</h2>
                    <div class="text-gray-700 text-sm space-y-1">
                        <div><span class="font-medium">Phone:</span> +7 (3519)580-111</div>
                        <div><span class="font-medium">Address:</span> City Center, Fashion Alley, Building 7</div>
                        <div><span class="font-medium">Email:</span> hello@ceylonglow.com</div>
                        <div><span class="font-medium">Hours:</span> Mon–Sat 9:00–18:00</div>
                    </div>
                    <div class="mt-4 h-48 rounded-lg bg-gray-100 grid place-items-center text-gray-500 text-sm">Map Placeholder</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-3">Follow us</h2>
                <div class="flex items-center gap-4 text-sm text-gray-700">
                    <a href="#" class="underline">Instagram</a>
                    <a href="#" class="underline">Facebook</a>
                    <a href="#" class="underline">Twitter</a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-3">FAQ</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="font-medium">How soon will you reply?</div>
                        <p class="text-gray-700">We typically respond within one business day.</p>
                    </div>
                    <div>
                        <div class="font-medium">Can I call to book?</div>
                        <p class="text-gray-700">Yes, call the number above or use our online booking section.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Include Professional Footer --}}
    @include('footer')

</body>
</html>


