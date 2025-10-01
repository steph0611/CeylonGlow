<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Order Confirmation</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="py-12">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Success Message -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    @if($order->payment_method === 'card')
                        Payment Successful!
                    @else
                        Order Confirmed!
                    @endif
                </h1>
                <p class="text-lg text-gray-600 mb-2">Thank you for your purchase!</p>
                <p class="text-gray-500">
                    @if($order->payment_method === 'card')
                        Your payment has been processed successfully and your order is confirmed.
                    @else
                        Your order has been placed successfully. Payment will be collected upon delivery.
                    @endif
                </p>
            </div>

            <!-- Payment Success Notification -->
            @if($order->payment_method === 'card')
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-green-900">Payment Processed Successfully</h3>
                            <p class="text-green-700 mt-1">Your card payment has been authorized and processed. You will receive a receipt via email shortly.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-blue-900">Order Confirmed - Cash on Delivery</h3>
                            <p class="text-blue-700 mt-1">Your order is confirmed. Payment will be collected when your order is delivered to you.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Order Details -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium">#{{ $order->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($order->placed_at)->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-medium 
                            @if($order->status === 'paid') bg-green-100 text-green-800
                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium">{{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="font-semibold text-[#506c2a]">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Order Items</h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500">Quantity: {{ $item['quantity'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-[#506c2a]">${{ number_format($item['line_total'], 2) }}</p>
                                <p class="text-sm text-gray-500">${{ number_format($item['price'], 2) }} each</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Information -->
            @if($order->shipping_address)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                    <div class="text-gray-700 whitespace-pre-line">{{ $order->shipping_address }}</div>
                </div>
            @endif

            <!-- Next Steps -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">What's Next?</h3>
                <ul class="space-y-2 text-blue-800">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        You will receive an email confirmation shortly.
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @if($order->payment_method === 'cash_on_delivery')
                            Payment will be collected upon delivery.
                        @else
                            Your payment has been processed successfully.
                        @endif
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        We'll notify you when your order ships.
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <!-- Primary Action - Go to Home -->
                <div class="text-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center bg-[#506c2a] text-white px-8 py-4 rounded-lg hover:bg-[#3e541f] transition-colors duration-200 font-medium text-lg shadow-lg hover:shadow-xl">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Go to Home
                    </a>
                </div>
                
                <!-- Secondary Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('customer.orders.index') }}" class="flex-1 bg-gray-100 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View All Orders
                    </a>
                    <a href="{{ route('products.index') }}" class="flex-1 bg-gray-100 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors duration-200 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
