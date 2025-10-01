<nav 
    x-data="{ open: false, navColor: 'black' }" 
    :class="navColor === 'black' ? 'text-gray-800 md:text-gray-800 text-gray-800' : 'text-white md:text-white text-gray-800'"
    class="bg-white/95 md:bg-transparent bg-white backdrop-blur-lg shadow-lg md:shadow-none fixed w-full z-50 border-b border-gray-200 md:border-transparent transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo (left) -->
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                    <img src="{{ asset('images/Logo.png') }}" alt="Ceylon Glow Logo" class="h-10 w-auto transition-transform duration-200 group-hover:scale-105">
                    <span class="hidden sm:block text-xl font-bold tracking-tight">Ceylon Glow</span>
                </a>
            </div>

            <!-- Navigation Links (center) -->
            <div class="hidden md:flex items-center space-x-8 font-medium">
                <a href="{{ url('/about') }}" class="relative px-3 py-2 text-sm font-medium transition-all duration-200 hover:text-amber-600 hover:scale-105">
                    <span class="relative z-10">About Us</span>
                    <span class="absolute inset-0 bg-amber-50 rounded-lg opacity-0 transition-opacity duration-200 hover:opacity-100"></span>
                </a>
                <a href="{{ url('/services') }}" class="relative px-3 py-2 text-sm font-medium transition-all duration-200 hover:text-amber-600 hover:scale-105">
                    <span class="relative z-10">Services</span>
                    <span class="absolute inset-0 bg-amber-50 rounded-lg opacity-0 transition-opacity duration-200 hover:opacity-100"></span>
                </a>
                <a href="{{ url('/membership') }}" class="relative px-3 py-2 text-sm font-medium transition-all duration-200 hover:text-amber-600 hover:scale-105">
                    <span class="relative z-10">Membership</span>
                    <span class="absolute inset-0 bg-amber-50 rounded-lg opacity-0 transition-opacity duration-200 hover:opacity-100"></span>
                </a>
                <a href="{{ url('/contact') }}" class="relative px-3 py-2 text-sm font-medium transition-all duration-200 hover:text-amber-600 hover:scale-105">
                    <span class="relative z-10">Contact Us</span>
                    <span class="absolute inset-0 bg-amber-50 rounded-lg opacity-0 transition-opacity duration-200 hover:opacity-100"></span>
                </a>
                <a href="{{ url('/products') }}" class="relative px-3 py-2 text-sm font-medium transition-all duration-200 hover:text-amber-600 hover:scale-105">
                    <span class="relative z-10">Products</span>
                    <span class="absolute inset-0 bg-amber-50 rounded-lg opacity-0 transition-opacity duration-200 hover:opacity-100"></span>
                </a>
            </div>


            <!-- Right Side: Profile, Teams, and Icons -->
            <div class="flex items-center space-x-3">

                @auth
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="relative hidden md:block">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium bg-transparent rounded-md hover:text-yellow-500 focus:outline-none transition">
                                        {{ Auth::user()->currentTeam->name }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="w-60">
                                        <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Team') }}</div>
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-dropdown-link>
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>
                                            <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Switch Teams') }}</div>
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    <!-- Settings Dropdown -->
                    <div class="relative hidden md:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium bg-transparent hover:text-yellow-500 focus:outline-none transition">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                @endif
                            </x-slot>
                            <x-slot name="content">
                                <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                                <x-dropdown-link href="{{ route('profile.show') }}">{{ __('Profile') }}</x-dropdown-link>
                                <x-dropdown-link href="{{ route('customer.orders.index') }}">{{ __('My Orders') }}</x-dropdown-link>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</x-dropdown-link>
                                @endif
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <!-- Login/Register Links for non-authenticated users -->
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-amber-600 transition-colors duration-200">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all duration-200 hover:scale-105 shadow-sm">Register</a>
                    </div>
                @endauth

                <!-- Icons -->
                <button class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105 text-gray-600 hover:text-amber-600" title="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110 2.5a7.5 7.5 0 016.65 14.15z" />
                    </svg>
                </button>
                @auth
                    <a href="{{ route('cart.index') }}" class="relative p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105 text-gray-600 hover:text-amber-600" title="Shopping Cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                        @php
                            $__cartItems = session('cart', []);
                            $__cartCount = 0;
                            foreach ($__cartItems as $__item) {
                                $__cartCount += (int) ($__item['quantity'] ?? 0);
                            }
                        @endphp
                        @if($__cartCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-xs flex items-center justify-center font-medium shadow-sm">{{ $__cartCount }}</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" class="relative p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105 text-gray-600 hover:text-amber-600" title="Login to access cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </a>
                @endauth
                <a href="tel:+94112223344" class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105 text-gray-600 hover:text-amber-600" title="Call Us">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.45l1.1 4.4a2 2 0 01-.45 1.82l-2.2 2.2a16.001 16.001 0 006.59 6.59l2.2-2.2a2 2 0 011.82-.45l4.4 1.1a2 2 0 011.45 1.94V19a2 2 0 01-2 2h-1C10.07 21 3 13.93 3 5z" />
                    </svg>
                </a>
                <a href="mailto:info@ceylonglow.com" class="p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105 text-gray-600 hover:text-amber-600" title="Email Us">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-amber-600 hover:bg-gray-100 focus:outline-none transition-all duration-200 hover:scale-105">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden">
        <div class="bg-white border-t border-gray-200 shadow-xl">
            <!-- Header with Logo Centered -->
            <div class="flex items-center justify-center py-4 border-b border-gray-100">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/Logo.png') }}" alt="Ceylon Glow Logo" class="h-8 w-auto">
                    <span class="text-lg font-bold text-gray-800">Ceylon Glow</span>
                </a>
            </div>

            <!-- Navigation Content -->
            <div class="px-6 py-4">
                <!-- Left Side - Navigation Links -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu</h3>
                    <div class="space-y-1">
                        <a href="{{ url('/about') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            About Us
                        </a>
                        <a href="{{ url('/services') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            Services
                        </a>
                        <a href="{{ url('/membership') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Membership
                        </a>
                        <a href="{{ url('/contact') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact Us
                        </a>
                        <a href="{{ url('/products') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Products
                        </a>
                    </div>
                </div>

                <!-- Right Side - Account Section -->
                @auth
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Account</h3>
                        
                        <!-- User Profile Card -->
                        <div class="flex items-center p-3 bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl mb-4">
                            <div class="flex-shrink-0">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-amber-200" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <div class="h-12 w-12 rounded-full bg-amber-200 flex items-center justify-center ring-2 ring-amber-300">
                                        <span class="text-lg font-semibold text-amber-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-base font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <!-- Account Actions -->
                        <div class="space-y-1">
                            <a href="{{ route('profile.show') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile
                            </a>
                            <a href="{{ route('customer.orders.index') }}" @click="open = false" class="flex items-center px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                My Orders
                            </a>
                            <a href="{{ route('cart.index') }}" @click="open = false" class="flex items-center justify-between px-3 py-2 text-base font-medium text-gray-700 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path>
                                    </svg>
                                    Cart
                                </div>
                                @php
                                    $__cartItems = session('cart', []);
                                    $__cartCount = 0;
                                    foreach ($__cartItems as $__item) {
                                        $__cartCount += (int) ($__item['quantity'] ?? 0);
                                    }
                                @endphp
                                @if($__cartCount > 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500 text-white">{{ $__cartCount }}</span>
                                @endif
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" @click="open = false" class="flex items-center w-full px-3 py-2 text-base font-medium text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Account</h3>
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" @click="open = false" class="flex items-center justify-center px-4 py-3 text-base font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login
                            </a>
                            <a href="{{ route('register') }}" @click="open = false" class="flex items-center justify-center px-4 py-3 text-base font-medium bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Register
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic nav text color -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbar = document.querySelector('nav');
            const sections = document.querySelectorAll('section');

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if(entry.isIntersecting){
                        const color = entry.target.dataset.navColor; // "light" or "dark"
                        navbar.__x.$data.navColor = color === 'dark' ? 'black' : 'white';
                    }
                });
            }, { threshold: 0.5 });

            sections.forEach(section => observer.observe(section));
        });
    </script>
</nav>
