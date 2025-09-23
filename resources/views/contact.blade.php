<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us - Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="relative w-full overflow-hidden h-64">
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
                    <h2 class="text-lg font-semibold mb-2">Get in touch</h2>
                    <p class="text-gray-600 text-sm mb-4">We'd love to hear from you. Fill out the form and we'll get back to you.</p>
                    <form class="space-y-3">
                        <input type="text" placeholder="Full name" class="w-full p-2 border rounded-lg">
                        <input type="email" placeholder="Email" class="w-full p-2 border rounded-lg">
                        <textarea placeholder="Message" rows="4" class="w-full p-2 border rounded-lg"></textarea>
                        <button type="button" class="bg-[#506c2a] text-white px-5 py-2.5 rounded-full">Send Message</button>
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

</body>
</html>


