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

    <section class="py-12">
        <div class="max-w-5xl mx-auto px-4">
            <a href="{{ route('products.index') }}" class="text-sm text-[#506c2a]">&larr; Back to products</a>
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8 bg-white rounded-xl shadow p-6">
                <div>
                    @if(!empty($product->image))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded">
                    @else
                        <img src="{{ asset('images/service-1.jpg') }}" alt="No image" class="w-full h-96 object-cover rounded">
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                    <div class="text-xl text-[#506c2a] font-semibold mb-4">${{ number_format($product->price, 2) }}</div>
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-2">Description</h2>
                        <p class="text-gray-700 whitespace-pre-line">{{ $product->description ?: 'No description available.' }}</p>
                    </div>
                    @php $qty = (int)($product->qty ?? 0); @endphp
                    <div class="mb-6 text-sm">
                        @if($qty === 0)
                            <span class="text-red-600">Out of stock</span>
                        @elseif($qty > 0 && $qty < 5)
                            <span class="text-amber-600">Low stock: {{ $product->qty }}</span>
                        @else
                            <span class="text-gray-600">In stock: {{ $product->qty }}</span>
                        @endif
                    </div>
                    @if($qty > 0)
                        @auth
                            <form method="POST" action="{{ route('cart.add', $product->getKey()) }}">
                                @csrf
                                <button type="submit" class="inline-block bg-[#506c2a] text-white px-6 py-3 rounded-full">Add to Cart</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="inline-block bg-[#506c2a] text-white px-6 py-3 rounded-full">Login to Add to Cart</a>
                        @endauth
                    @else
                        <span class="inline-block bg-gray-300 text-gray-600 px-6 py-3 rounded-full" aria-disabled="true">Out of Stock</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

</body>
</html>


