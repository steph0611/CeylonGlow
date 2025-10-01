<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Checkout</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                <p class="text-gray-600 mt-2">Complete your purchase</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow p-6 sticky top-4">
                        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                        
                        @if($type === 'single_product')
                            <!-- Single Product Item -->
                            <div class="flex items-center space-x-4 mb-4 pb-4 border-b">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $product['name'] }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ $quantity }}</p>
                                    <p class="text-sm font-medium text-[#506c2a]">${{ number_format($product['price'], 2) }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Cart Items -->
                            <div class="space-y-3 mb-4 pb-4 border-b max-h-64 overflow-y-auto">
                                @foreach($items as $item)
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded-lg">
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900 text-sm">{{ $item['name'] }}</h3>
                                            <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                            <p class="text-xs font-medium text-[#506c2a]">${{ number_format($item['line_total'], 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Price Breakdown -->
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax (10%)</span>
                                <span>${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-semibold text-lg pt-2 border-t">
                                <span>Total</span>
                                <span class="text-[#506c2a]">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('checkout.process') }}" x-data="{ paymentMethod: 'card' }">
                        @csrf
                        
                        <!-- Payment Method -->
                        <div class="bg-white rounded-xl shadow p-6 mb-6">
                            <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" id="card" name="payment_method" value="card" x-model="paymentMethod" class="h-4 w-4 text-[#506c2a] focus:ring-[#506c2a] border-gray-300">
                                    <label for="card" class="ml-3 text-sm font-medium text-gray-700">Credit/Debit Card</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="cash" name="payment_method" value="cash_on_delivery" x-model="paymentMethod" class="h-4 w-4 text-[#506c2a] focus:ring-[#506c2a] border-gray-300">
                                    <label for="cash" class="ml-3 text-sm font-medium text-gray-700">Cash on Delivery</label>
                                </div>
                            </div>

                            <!-- Card Payment Form -->
                            <div x-show="paymentMethod === 'card'" x-transition class="mt-6 space-y-4">
                                <div>
                                    <label for="cardholder_name" class="block text-sm font-medium text-gray-700 mb-2">Cardholder Name</label>
                                    <input type="text" id="cardholder_name" name="cardholder_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-transparent" placeholder="John Doe">
                                </div>
                                
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                    <input type="text" id="card_number" name="card_number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-transparent" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" id="expiry_date" name="expiry_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-transparent" placeholder="MM/YY">
                                    </div>
                                    <div>
                                        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                        <input type="text" id="cvv" name="cvv" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-transparent" placeholder="123" maxlength="4">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="bg-white rounded-xl shadow p-6 mb-6">
                            <h2 class="text-xl font-semibold mb-4">Address Information</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-2">Billing Address</label>
                                    <textarea id="billing_address" name="billing_address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-transparent" placeholder="Enter your billing address" required></textarea>
                                </div>
                                
                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-transparent" placeholder="Enter your shipping address" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <button type="submit" class="w-full bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3e541f] transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                <span x-text="paymentMethod === 'card' ? 'Pay Now' : 'Place Order'"></span>
                            </button>
                            
                            <p class="text-xs text-gray-500 text-center mt-3">
                                By placing this order, you agree to our terms and conditions.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Format card number input
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });

        // Format expiry date input
        document.getElementById('expiry_date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // Format CVV input
        document.getElementById('cvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    </script>

</body>
</html>
