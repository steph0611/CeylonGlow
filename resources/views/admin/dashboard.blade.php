<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Products & Banners</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <style>
        .btn-primary {
            background: #111827; /* dark slate */
            color: #fff; 
            padding: .6rem 1.25rem;
            border-radius: 9999px;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-primary:hover {
            background: #1f2937; /* darker slate */
        }
        .btn-secondary {
            background: #f3f4f6;
            color: #111827;
            padding: .6rem 1.25rem;
            border-radius: 9999px;
            transition: all .2s;
        }
        .btn-secondary:hover {
            background: #e5e7eb;
        }
        .tab-btn.active {
            background: #111827 !important;
            color: #fff !important;
        }
        .muted { 
            color: #6b7280;
        }
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

<!-- Header -->
<header class="bg-white/80 backdrop-blur shadow-sm sticky top-0 z-10">
    <div class="max-w-6xl mx-auto flex items-center justify-between py-4 px-6">
        <div>
            <h1 class="text-xl font-bold tracking-tight">Admin Dashboard</h1>
            <p class="text-xs text-gray-500 mt-0.5">Manage products and homepage banners</p>
        </div>
        <a href="/" class="btn-secondary">Back to Site</a>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-6 space-y-8">

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 p-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 p-3 rounded-lg">{{ session('error') }}</div>
    @endif

    @php
        $productCount = isset($products) ? $products->count() : 0;
        $bannerCount = isset($banners) ? $banners->count() : 0;
    @endphp

    <!-- Summary Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="h-10 w-10 rounded-lg bg-gray-900 text-white flex items-center justify-center text-sm">PR</div>
            <div>
                <div class="text-xs text-gray-500">Total Products</div>
                <div class="text-xl font-semibold">{{ $productCount }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="h-10 w-10 rounded-lg bg-amber-600 text-white flex items-center justify-center text-sm">BN</div>
            <div>
                <div class="text-xs text-gray-500">Active Banners</div>
                <div class="text-xl font-semibold">{{ $bannerCount }}</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
            <div class="h-10 w-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-sm">OS</div>
            <div>
                <div class="text-xs text-gray-500">Low Stock Items</div>
                <div class="text-xl font-semibold">
                    @if(isset($products))
                        {{ $products->where('qty', '>', 0)->where('qty', '<', 5)->count() }}
                    @else
                        0
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Tabs -->
    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex gap-2">
            <button class="tab-btn btn-secondary active" data-tab="products">Products</button>
            <button class="tab-btn btn-secondary" data-tab="banners">Banners</button>
            <button class="tab-btn btn-secondary" data-tab="services">Services</button>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">+ Add Product</a>
    </div>

    <!-- Products Section -->
    <div id="products" class="tab-content">
        <livewire:admin.product-table />
    </div>

    <!-- Banners Section -->
    <div id="banners" class="tab-content hidden">
        <livewire:admin.banner-manager />
    </div>

    <!-- Services Section -->
    <div id="services" class="tab-content hidden">
        <livewire:admin.service-table />
    </div>

</main>

<script>
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            tabButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            tabContents.forEach(tc => tc.classList.add('hidden'));
            document.getElementById(btn.dataset.tab).classList.remove('hidden');
        });
    });

    // Simple product table search
    const searchInput = document.getElementById('productSearch');
    const tableBody = document.getElementById('productTableBody');
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase();
            Array.from(tableBody.querySelectorAll('tr')).forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        });
    }
</script>

    @livewireScripts
</body>
</html>
