<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ceylon Glow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <style>
            .hero-bg{background-image:url('/images/hero-spa.jpg');background-size:cover;background-position:center;}
            .section-card{background:#bfa38933;border-radius:14px}
            .btn-primary{background:#506c2a;color:#fff;padding:.75rem 1.5rem;border-radius:9999px}
            .btn-primary:hover{background:#3e541f}
            .muted{color:#6b7280}
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-100">
        <x-banner />

        <div class="min-h-screen">
            {{-- Navigation --}}
            @include('navigation-menu')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
