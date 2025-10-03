<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Admin Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .stat-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }
        .stat-card-5 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }
        .tab-btn {
            @apply px-4 py-2 rounded-lg font-medium transition-all duration-200;
        }
        .tab-btn.active {
            @apply bg-[#506c2a] text-white shadow-lg;
        }
        .tab-btn:not(.active) {
            @apply bg-gray-100 text-gray-600 hover:bg-gray-200;
        }
        .btn-primary {
            @apply bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3d5220] transition-colors font-medium;
        }
        .btn-secondary {
            @apply bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-medium;
        }
        .status-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
        }
        .status-pending { @apply bg-yellow-100 text-yellow-800; }
        .status-processing { @apply bg-blue-100 text-blue-800; }
        .status-completed { @apply bg-green-100 text-green-800; }
        .status-cancelled { @apply bg-red-100 text-red-800; }
    </style>
</head>
<body class="antialiased bg-gray-50">

<!-- Header -->
<div class="gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Admin Dashboard</h1>
                <p class="text-blue-100">Welcome back! Here's what's happening with your business today.</p>
            </div>
            <div class="flex items-center space-x-6">
                <div class="text-right">
                    <div class="text-2xl font-bold">{{ now()->format('M d, Y') }}</div>
                    <div class="text-blue-100">{{ now()->format('l') }}</div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm text-blue-100">Admin</div>
                        <div class="text-sm font-semibold">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="ml-4">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="p-4 rounded-lg bg-green-100 border border-green-200 text-green-700">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="p-4 rounded-lg bg-red-100 border border-red-200 text-red-700">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif

<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-6 mb-8">
        <!-- Products Card -->
        <div class="stat-card rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold">{{ $products->count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Banners Card -->
        <div class="stat-card-2 rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-100 text-sm font-medium">Active Banners</p>
                    <p class="text-3xl font-bold">{{ $banners->count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="stat-card-3 rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-cyan-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold">{{ $totalOrders ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="stat-card-4 rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Pending Orders</p>
                    <p class="text-3xl font-bold">{{ $pendingOrders ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="stat-card-5 rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format(($orders->sum('total') ?? 0), 2) }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Bookings Card -->
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl p-6 card-hover text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Bookings</p>
                    <p class="text-3xl font-bold">{{ $totalBookings ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Low Stock Card -->
        <div class="bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl p-6 card-hover text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Low Stock</p>
                    <p class="text-3xl font-bold">{{ $totalLowStock ?? 0 }}</p>
                    <p class="text-orange-100 text-xs mt-1">≤ {{ $lowStockThreshold ?? 10 }} items</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Out of Stock Card -->
        <div class="bg-gradient-to-r from-red-500 to-red-700 rounded-2xl p-6 card-hover text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Out of Stock</p>
                    <p class="text-3xl font-bold">{{ $totalOutOfStock ?? 0 }}</p>
                    <p class="text-red-100 text-xs mt-1">0 items</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Orders Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Orders Overview</h3>
            <div class="relative h-80">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Revenue Trend</h3>
            <div class="relative h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Stock Alerts Section -->
    @if(($totalLowStock > 0) || ($totalOutOfStock > 0))
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                Stock Alerts
            </h3>
            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                {{ $totalLowStock + $totalOutOfStock }} items need attention
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Out of Stock Products -->
            @if($totalOutOfStock > 0)
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-red-900">Out of Stock ({{ $totalOutOfStock }})</h4>
                        <p class="text-red-600 text-sm">Products with 0 quantity</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($outOfStockProducts->take(5) as $product)
                    <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-red-200">
                        <div class="flex items-center">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/service-1.jpg') }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg mr-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-700 transition-colors">
                            Restock
                        </a>
                    </div>
                    @endforeach
                    @if($totalOutOfStock > 5)
                    <p class="text-sm text-red-600 text-center">... and {{ $totalOutOfStock - 5 }} more products</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Low Stock Products -->
            @if($totalLowStock > 0)
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-orange-900">Low Stock ({{ $totalLowStock }})</h4>
                        <p class="text-orange-600 text-sm">Products with ≤ {{ $lowStockThreshold }} quantity</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach($lowStockProducts->take(5) as $product)
                    <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-orange-200">
                        <div class="flex items-center">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/service-1.jpg') }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg mr-3">
                            <div>
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $product->qty }} • ${{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-orange-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-orange-700 transition-colors">
                            Restock
                        </a>
                    </div>
                    @endforeach
                    @if($totalLowStock > 5)
                    <p class="text-sm text-orange-600 text-center">... and {{ $totalLowStock - 5 }} more products</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <div class="flex flex-wrap gap-4 mb-6">
            <button class="tab-btn active" data-tab="products">Products</button>
            <button class="tab-btn" data-tab="banners">Banners</button>
            <button class="tab-btn" data-tab="services">Services</button>
            <button class="tab-btn" data-tab="memberships">Memberships</button>
            <button class="tab-btn" data-tab="customers">Customers</button>
            <button class="tab-btn" data-tab="orders">Orders</button>
            <button class="tab-btn" data-tab="bookings">Bookings</button>
        </div>

        <!-- Products Tab -->
        <div id="products" class="tab-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Product Management</h3>
                <a href="{{ route('admin.products.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Product
                </a>
            </div>
            
            @if(isset($products) && $products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-gray-50 rounded-xl p-6 card-hover">
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/service-1.jpg') }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-lg">
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h4>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->description, 80) }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-2xl font-bold text-[#506c2a]">${{ number_format($product->price, 2) }}</span>
                                <div class="text-right">
                                    <span class="text-sm text-gray-500">Qty: {{ $product->qty }}</span>
                                    @if($product->qty <= 0)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Out of Stock
                                            </span>
                                        </div>
                                    @elseif($product->qty <= ($lowStockThreshold ?? 10))
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                Low Stock
                                            </span>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                In Stock
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 text-white py-2 px-3 rounded-lg text-sm hover:bg-red-700 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No products available</p>
                    <p class="text-gray-400 text-sm">Add your first product to get started</p>
                </div>
            @endif
        </div>

        <!-- Banners Tab -->
        <div id="banners" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Banner Management</h3>
                <button class="btn-primary" onclick="openBannerModal()">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Banner
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($banners as $banner)
                    <div class="bg-gray-50 rounded-xl p-6 card-hover">
                        <div class="aspect-w-16 aspect-h-9 mb-4">
                            <img src="{{ $banner->image ? (str_starts_with($banner->image, 'data:') ? $banner->image : asset('storage/' . $banner->image)) : asset('images/service-1.jpg') }}" alt="{{ $banner->title ?? 'Banner' }}" class="w-full h-32 object-cover rounded-lg">
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $banner->title ?? 'Banner ' . $banner->position }}</h4>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($banner->description ?? 'No description', 80) }}</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Position {{ $banner->position }}</span>
                        </div>
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" class="w-full" onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 text-white py-2 px-3 rounded-lg text-sm hover:bg-red-700 transition-colors">
                                    Delete Banner
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Services Tab -->
        <div id="services" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Service Management</h3>
                <a href="{{ route('admin.services.create') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Service
                </a>
            </div>
            
            @if(isset($services) && $services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $service)
                        <div class="bg-gray-50 rounded-xl p-6 card-hover">
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                <img src="{{ $service->image ? asset('storage/' . $service->image) : asset('images/service-1.jpg') }}" alt="{{ $service->name }}" class="w-full h-32 object-cover rounded-lg">
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $service->name }}</h4>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($service->description, 80) }}</p>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-2xl font-bold text-[#506c2a]">${{ number_format($service->price, 2) }}</span>
                                <span class="text-sm text-gray-500">{{ $service->duration ?? 'N/A' }}</span>
                            </div>
                            @if(isset($service->category))
                                <div class="mb-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $service->category }}</span>
                                </div>
                            @endif
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 text-white py-2 px-3 rounded-lg text-sm hover:bg-red-700 transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No services available</p>
                    <p class="text-gray-400 text-sm">Add your first service to get started</p>
                </div>
            @endif
        </div>

        <!-- Memberships Tab -->
        <div id="memberships" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Membership Management</h3>
                <a href="{{ route('admin.memberships.index') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Manage Memberships
                </a>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Membership Management</h4>
                    <p class="text-gray-500 mb-4">Create and manage membership plans and subscriptions</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('admin.memberships.index') }}" class="btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            View All Memberships
                        </a>
                        <a href="{{ route('admin.membership-purchases.index') }}" class="btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            View Purchases
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers Tab -->
        <div id="customers" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Customer Management</h3>
                <a href="{{ route('admin.customers.index') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Manage Customers
                </a>
            </div>
            
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Customer Management</h4>
                    <p class="text-gray-500 mb-4">View and manage all registered customers</p>
                    <a href="{{ route('admin.customers.index') }}" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        View All Customers
                    </a>
                </div>
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Recent Orders</h3>
                <a href="{{ route('orders.index') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    View All Orders
                </a>
            </div>
            @if(isset($orders) && $orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders->take(5) as $order)
                        <div class="bg-gray-50 rounded-xl p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-white p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-[#506c2a]" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Order #{{ substr((string) $order->_id, -8) }}</h4>
                                        <p class="text-gray-600 text-sm">{{ $order->customer['name'] ?? 'Guest' }} • {{ count($order->items ?? []) }} items</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">${{ number_format((float) ($order->total ?? 0), 2) }}</div>
                                    <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                                        {{ ucfirst($order->status ?? 'pending') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No orders found</p>
                    <p class="text-gray-400 text-sm">Orders will appear here when customers place them</p>
                </div>
            @endif
        </div>

        <!-- Bookings Tab -->
        <div id="bookings" class="tab-content hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Recent Bookings</h3>
                <a href="{{ route('admin.bookings.index') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    View All Bookings
                </a>
            </div>
            @if(isset($bookings) && $bookings->count() > 0)
                <div class="space-y-4">
                    @foreach($bookings->take(5) as $booking)
                        <div class="bg-gray-50 rounded-xl p-6 card-hover">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="bg-white p-3 rounded-lg">
                                        <svg class="w-6 h-6 text-[#506c2a]" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $booking->customer_name }}</h4>
                                        <p class="text-gray-600 text-sm">{{ $booking->service_name }} • {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                                        <p class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">${{ number_format($booking->service_price, 2) }}</div>
                                    <span class="status-badge status-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-lg">No bookings found</p>
                    <p class="text-gray-400 text-sm">Bookings will appear here when customers make appointments</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Tab functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');
            
            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));
            // Show target tab content
            document.getElementById(targetTab).classList.remove('hidden');
        });
    });

    // Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
            datasets: [{
                data: [{{ $pendingOrders ?? 0 }}, {{ ($orders->where('status', 'processing')->count()) ?? 0 }}, {{ ($orders->where('status', 'completed')->count()) ?? 0 }}, {{ ($orders->where('status', 'cancelled')->count()) ?? 0 }}],
                backgroundColor: [
                    '#FCD34D',
                    '#3B82F6',
                    '#10B981',
                    '#EF4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10
                }
            }
        }
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [1200, 1900, 3000, 5000, 2000, 3000],
                borderColor: '#506c2a',
                backgroundColor: 'rgba(80, 108, 42, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#506c2a',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });
});
</script>

<!-- Banner Creation Modal -->
<div id="bannerModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Add New Banner</h3>
                <button onclick="closeBannerModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner 1 (Position 1)</label>
                        <input type="file" name="banner1" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner 2 (Position 2)</label>
                        <input type="file" name="banner2" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner 3 (Position 3)</label>
                        <input type="file" name="banner3" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner 4 (Position 4)</label>
                        <input type="file" name="banner4" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#506c2a] focus:border-[#506c2a]">
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-xl">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-800 font-medium">Banner Upload Guidelines</p>
                            <p class="text-sm text-blue-700 mt-1">
                                You can upload up to 4 banners. Each banner will be assigned to a specific position (1-4). 
                                Uploading a new banner will replace the existing banner at that position.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeBannerModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#506c2a] text-white rounded-lg hover:bg-[#3d5220] transition-colors">
                        Upload Banners
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openBannerModal() {
    document.getElementById('bannerModal').classList.remove('hidden');
}

function closeBannerModal() {
    document.getElementById('bannerModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('bannerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBannerModal();
    }
});
</script>

</body>
</html>