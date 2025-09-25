<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order - Admin</title>
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
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

<div class="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Order</h1>
            <p class="text-gray-600 mt-1">Order #{{ substr((string) $order->_id, -8) }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('orders.show', (string) $order->_id) }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Details
            </a>
            <a href="{{ route('orders.index') }}" class="btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Orders
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-200 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Order Information</h2>
                
                <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" required>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Update the current status of this order</p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Order Notes</label>
                        <textarea name="notes" id="notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]" placeholder="Add any notes about this order...">{{ $order->notes ?? '' }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Add internal notes or comments about this order</p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center space-x-3 pt-4">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Order
                        </button>
                        <a href="{{ route('orders.show', (string) $order->_id) }}" class="btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Current Status</h2>
                <div class="text-center">
                    <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-medium">#{{ substr((string) $order->_id, -8) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Customer:</span>
                        <span class="font-medium">{{ $order->customer['name'] ?? 'Guest' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Items:</span>
                        <span class="font-medium">{{ count($order->items ?? []) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total:</span>
                        <span class="font-medium">${{ number_format((float) ($order->total ?? 0), 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium">{{ $order->placed_at ? \Carbon\Carbon::parse($order->placed_at)->format('M d, Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    @if($order->status === 'pending')
                        <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="inline w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="processing">
                            <input type="hidden" name="notes" value="{{ $order->notes ?? '' }}">
                            <button type="submit" class="w-full btn-primary">
                                Mark as Processing
                            </button>
                        </form>
                    @endif
                    
                    @if($order->status === 'processing')
                        <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="inline w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <input type="hidden" name="notes" value="{{ $order->notes ?? '' }}">
                            <button type="submit" class="w-full btn-primary">
                                Mark as Completed
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form method="POST" action="{{ route('orders.update', (string) $order->_id) }}" class="inline w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <input type="hidden" name="notes" value="{{ $order->notes ?? '' }}">
                            <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors" 
                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                <div class="space-y-3">
                    @foreach($order->items ?? [] as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium text-sm">{{ $item['name'] ?? 'Unknown Item' }}</div>
                                <div class="text-xs text-gray-500">Qty: {{ $item['quantity'] ?? 0 }}</div>
                            </div>
                            <div class="text-sm font-medium">
                                ${{ number_format((float) ($item['line_total'] ?? 0), 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


