<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Customer Management</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            @apply bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3d5220] transition-colors font-medium;
        }
        .btn-secondary {
            @apply bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors font-medium;
        }
        .btn-danger {
            @apply bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium;
        }
        .btn-edit {
            @apply bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">

<!-- Header -->
<div class="gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Customer Management</h1>
                <p class="text-blue-100">Manage all registered customers and their information</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Dashboard</span>
                </a>
                <a href="{{ route('admin.customers.create') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Add Customer</span>
                </a>
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
    <!-- Customer Table -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">All Customers</h3>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500">
                    Total: {{ \App\Models\Customer::count() }} customers
                </div>
            </div>
        </div>

        @livewire('admin.customer-table')
    </div>
</div>

@livewireScripts
</body>
</html>
