<nav 
    x-data="{ open: false, navColor: 'black' }" 
    :class="navColor === 'black' ? 'text-gray-800 md:text-gray-800 text-gray-800' : 'text-white md:text-white text-gray-800'"
    class="bg-white/95 md:bg-white/80 bg-white backdrop-blur-lg shadow-lg md:shadow-lg fixed w-full z-50 border-b border-gray-200 md:border-gray-200 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Left Side: Mobile Hamburger (Mobile only) / Logo (Desktop) -->
            <div class="flex items-center">
                <!-- Mobile Hamburger (visible on mobile only) -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-amber-600 hover:bg-gray-100 focus:outline-none transition-all duration-200 hover:scale-105 md:hidden">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Logo (Desktop - Left aligned) -->
                <a href="{{ route('dashboard') }}" class="hidden md:flex items-center space-x-2 group">
                    <img src="{{ asset('images/Logo.png') }}" alt="Ceylon Glow Logo" class="h-10 w-auto transition-transform duration-200 group-hover:scale-105">
                    <span class="text-xl font-bold tracking-tight">Ceylon Glow</span>
                </a>
            </div>

            <!-- Center: Centered Logo (Mobile) / Desktop Navigation Links -->
            <div class="flex items-center">
                <!-- Centered Logo (Mobile) -->
                <a href="{{ route('dashboard') }}" class="md:hidden flex items-center space-x-2 group">
                    <img src="{{ asset('images/Logo.png') }}" alt="Ceylon Glow Logo" class="h-10 w-auto transition-transform duration-200 group-hover:scale-105">
                    <span class="text-xl font-bold tracking-tight">Ceylon Glow</span>
                </a>

                <!-- Desktop Navigation Links (hidden on mobile) -->
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
            </div>

            <!-- Right Side: Account, Teams, and User Actions -->
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

                @else
                    <!-- Login/Register Links for non-authenticated users -->
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-amber-600 transition-colors duration-200">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all duration-200 hover:scale-105 shadow-sm">Register</a>
                    </div>
                @endauth

                <!-- Account Dropdown -->
                @auth
                    <div class="relative" x-data="{ accountOpen: false }">
                        <button @click="accountOpen = !accountOpen" class="flex items-center p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 hover:scale-105 text-gray-600 hover:text-amber-600" title="Account">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center">
                                    <span class="text-sm font-semibold text-amber-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </button>

                        <!-- Account Dropdown Menu -->
                        <div x-show="accountOpen" @click.away="accountOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                            <span class="text-sm font-semibold text-amber-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile
                                </a>
                                <a href="{{ route('customer.orders.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    My Orders
                                </a>
                                <a href="{{ route('cart.index') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <div class="border-t border-gray-100 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-amber-600 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 text-sm font-medium bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-all duration-200">Register</a>
                    </div>
                @endauth
            </div>

        </div>
    </div>

    <!-- Mobile menu dropdown -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="md:hidden absolute left-4 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
        <!-- Navigation Links -->
        <div class="py-2">
            <a href="{{ url('/about') }}" @click="open = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                About Us
            </a>
            <a href="{{ url('/services') }}" @click="open = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                Services
            </a>
            <a href="{{ url('/membership') }}" @click="open = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Membership
            </a>
            <a href="{{ url('/contact') }}" @click="open = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Contact Us
            </a>
            <a href="{{ url('/products') }}" @click="open = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Products
            </a>
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
