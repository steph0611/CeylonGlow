<nav 
    x-data="{ open: false, navColor: 'black' }" 
    :class="navColor === 'black' ? 'text-black' : 'text-white'"
    class="bg-transparent backdrop-blur-md shadow fixed w-full z-50 border-b border-transparent transition-colors duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo (left) -->
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Ceylon Glow Logo" class="h-10">
                </a>
            </div>

            <!-- Navigation Links (center) -->
            <div class="hidden md:flex space-x-10 font-medium mix-blend-difference">
                <a href="{{ url('/about') }}" class="hover:text-yellow-500">About Us</a>
                <a href="{{ url('/services') }}" class="hover:text-yellow-500">Services</a>
                <a href="{{ url('/membership') }}" class="hover:text-yellow-500">Membership</a>
                <a href="{{ url('/contact') }}" class="hover:text-yellow-500">Contact Us</a>
                <a href="{{ url('/products') }}" class="hover:text-yellow-500">Products</a>
            </div>


            <!-- Right Side: Profile, Teams, and Icons -->
            <div class="flex items-center space-x-4 mix-blend-difference">

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
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-yellow-500">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium hover:text-yellow-500">Register</a>
                    </div>
                @endauth

                <!-- Icons -->
                <button class="hover:text-yellow-500 md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110 2.5a7.5 7.5 0 016.65 14.15z" />
                    </svg>
                </button>
                @auth
                    <a href="{{ route('cart.index') }}" class="relative hover:text-yellow-500 md:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <span class="absolute -top-2 -right-2 min-w-5 h-5 px-1 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">{{ $__cartCount }}</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" class="relative hover:text-yellow-500 md:block" title="Login to access cart">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l3-8H6.4M7 13L5.4 5M7 13l-2 9m12-9l-2 9M9 22a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </a>
                @endauth
                <a href="tel:+94112223344" class="hover:text-yellow-500 md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.45l1.1 4.4a2 2 0 01-.45 1.82l-2.2 2.2a16.001 16.001 0 006.59 6.59l2.2-2.2a2 2 0 011.82-.45l4.4 1.1a2 2 0 011.45 1.94V19a2 2 0 01-2 2h-1C10.07 21 3 13.93 3 5z" />
                    </svg>
                </a>
                <a href="mailto:info@ceylonglow.com" class="hover:text-yellow-500 md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
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
