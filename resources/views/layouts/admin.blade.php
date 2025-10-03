<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - ' . config('app.name', 'Ceylon Glow'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <style>
        .admin-sidebar {
            background: linear-gradient(135deg, #506c2a 0%, #3d5220 100%);
        }
        .admin-nav-link {
            @apply block px-4 py-2 text-sm text-white hover:bg-white hover:bg-opacity-10 transition-colors duration-200;
        }
        .admin-nav-link.active {
            @apply bg-white bg-opacity-20;
        }
        .btn-primary {
            @apply bg-[#506c2a] text-white px-4 py-2 rounded-lg hover:bg-[#3d5220] transition-colors;
        }
        .btn-secondary {
            @apply bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors;
        }
        .btn-danger {
            @apply bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors;
        }
        .status-badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        .status-active { @apply bg-green-100 text-green-800; }
        .status-inactive { @apply bg-red-100 text-red-800; }
        .status-pending { @apply bg-yellow-100 text-yellow-800; }
        .status-confirmed { @apply bg-blue-100 text-blue-800; }
        .status-cancelled { @apply bg-red-100 text-red-800; }
        .status-completed { @apply bg-green-100 text-green-800; }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="admin-sidebar w-64 min-h-screen">
            <div class="p-6">
                <h1 class="text-xl font-bold text-white">Ceylon Glow</h1>
                <p class="text-sm text-white opacity-75">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.customers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fas fa-users mr-2"></i> Customers
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="admin-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt mr-2"></i> Bookings
                </a>
                <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box mr-2"></i> Products
                </a>
                <a href="{{ route('admin.services.index') }}" class="admin-nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-spa mr-2"></i> Services
                </a>
                <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart mr-2"></i> Orders
                </a>
                <a href="{{ route('admin.memberships.index') }}" class="admin-nav-link {{ request()->routeIs('admin.memberships.*') ? 'active' : '' }}">
                    <i class="fas fa-crown mr-2"></i> Memberships
                </a>
                <a href="{{ route('admin.banners.index') }}" class="admin-nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-image mr-2"></i> Banners
                </a>
            </nav>
            
            <div class="absolute bottom-0 w-64 p-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-nav-link w-full text-left">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Admin Panel')</h2>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 bg-[#506c2a] rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-100 border border-green-200 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-200 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
</body>
</html>
