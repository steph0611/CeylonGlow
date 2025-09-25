<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details - Admin</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .status-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
        }
        .status-pending { @apply bg-yellow-100 text-yellow-800; }
        .status-processing { @apply bg-blue-100 text-blue-800; }
        .status-completed { @apply bg-green-100 text-green-800; }
        .status-cancelled { @apply bg-red-100 text-red-800; }
        
        .btn-primary { @apply bg-[#506c2a] text-white px-4 py-2 rounded-lg hover:bg-[#3d5220] transition-colors; }
        .btn-secondary { @apply bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors; }
        .btn-danger { @apply bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors; }
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

<div class="max-w-6xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
            <p class="text-gray-600 mt-1">Order #{{ substr((string) $order->_id, -8) }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('orders.edit', (string) $order->_id) }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Order
            </a>
            <a href="{{ route('orders.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Orders
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Status Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Order Status</h2>
                    <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Order Date:</span>
                        <div class="font-medium">{{ $order->placed_at ? \Carbon\Carbon::parse($order->placed_at)->format('M d, Y \a\t g:i A') : 'N/A' }}</div>
                    </div>
                    <div>
                        <span class="text-gray-600">Order ID:</span>
                        <div class="font-medium font-mono">{{ (string) $order->_id }}</div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items ({{ count($order->items ?? []) }} items)</h2>
                <div class="space-y-4">
                    @foreach($order->items ?? [] as $index => $item)
                        <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-900 text-lg">{{ $item['name'] ?? 'Unknown Item' }}</h3>
                                <div class="text-sm text-gray-500 mt-1">
                                    <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs">Product ID: {{ $item['product_id'] ?? 'N/A' }}</span>
                                </div>
                                <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600">
                                    <span>Quantity: <span class="font-medium text-gray-900">{{ $item['quantity'] ?? 0 }}</span></span>
                                    <span>Unit Price: <span class="font-medium text-gray-900">${{ number_format((float) ($item['price'] ?? 0), 2) }}</span></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-[#506c2a]">${{ number_format((float) ($item['line_total'] ?? 0), 2) }}</div>
                                <div class="text-xs text-gray-500">Line Total</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Notes -->
            @if(!empty($order->notes))
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Notes</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-[#506c2a]">{{ count($order->items ?? []) }}</div>
                            <div class="text-gray-600">Items</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-[#506c2a]">{{ array_sum(array_column($order->items ?? [], 'quantity')) }}</div>
                            <div class="text-gray-600">Total Qty</div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format((float) ($order->total ?? 0), 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">Free</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="text-gray-900">$0.00</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900">Total</span>
                                <span class="text-[#506c2a]">${{ number_format((float) ($order->total ?? 0), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-[#506c2a] rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $order->customer['name'] ?? 'Guest Customer' }}</div>
                            <div class="text-sm text-gray-500">Customer ID: {{ $order->customer['id'] ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium text-gray-900">{{ $order->customer['email'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Date:</span>
                            <span class="font-medium text-gray-900">{{ $order->placed_at ? \Carbon\Carbon::parse($order->placed_at)->format('M d, Y \a\t g:i A') : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order Age:</span>
                            <span class="font-medium text-gray-900">{{ $order->placed_at ? \Carbon\Carbon::parse($order->placed_at)->diffForHumans() : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="processing">
                            <button type="submit" class="w-full btn-primary">
                                Mark as Processing
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'processing')
                        <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="w-full btn-primary">
                                Mark as Completed
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="w-full btn-danger" 
                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Timeline</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Order Placed</p>
                            <p class="text-xs text-gray-500">{{ $order->placed_at ? \Carbon\Carbon::parse($order->placed_at)->format('M d, Y \a\t g:i A') : 'N/A' }}</p>
                        </div>
                    </div>
                    
                    @if($order->status === 'processing' || $order->status === 'completed')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Processing</p>
                                <p class="text-xs text-gray-500">Order is being prepared</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status === 'completed')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Completed</p>
                                <p class="text-xs text-gray-500">Order has been fulfilled</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status === 'cancelled')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Cancelled</p>
                                <p class="text-xs text-gray-500">Order has been cancelled</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


