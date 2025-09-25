<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details - Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 bg-gray-50">

@include('navigation-menu')

<section class="pt-28 pb-10">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Details</h1>
                    <p class="text-gray-600">Order #{{ substr((string) $order->_id, -8) }}</p>
                </div>
                <a href="{{ route('customer.orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#506c2a]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Status -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h2>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->status ?? 'pending') }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            Placed on {{ $order->placed_at ? \Carbon\Carbon::parse($order->placed_at)->format('M d, Y \a\t g:i A') : 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items ?? [] as $item)
                            <div class="flex items-center justify-between py-4 border-b border-gray-200 last:border-b-0">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item['name'] ?? 'Unknown Item' }}</h3>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item['quantity'] ?? 0 }}</p>
                                    <p class="text-sm text-gray-500">Price: ${{ number_format((float) ($item['price'] ?? 0), 2) }} each</p>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format((float) ($item['line_total'] ?? 0), 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <!-- Order Summary Card -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format((float) ($order->total ?? 0), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">Free</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-base font-semibold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-gray-900">${{ number_format((float) ($order->total ?? 0), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="text-gray-600">Name:</span>
                            <span class="text-gray-900 ml-2">{{ $order->customer['name'] ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Email:</span>
                            <span class="text-gray-900 ml-2">{{ $order->customer['email'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                @if(!empty($order->notes))
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Notes</h2>
                        <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Need Help?</h2>
                    <div class="space-y-3">
                        <a href="{{ route('contact') }}" 
                           class="block w-full text-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#506c2a]">
                            Contact Support
                        </a>
                        @if($order->status === 'pending')
                            <button class="block w-full text-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Cancel Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
