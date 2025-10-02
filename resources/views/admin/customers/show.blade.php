<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceylon Glow - Customer Details</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    </style>
</head>
<body class="antialiased bg-gray-50">

<!-- Header -->
<div class="gradient-bg text-white">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Customer Details</h1>
                <p class="text-blue-100">View and manage customer information</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.customers.index') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Customers</span>
                </a>
                <a href="{{ route('admin.customers.edit', $customer->_id) }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit Customer</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Customer Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center">
                    <div class="mx-auto h-24 w-24 rounded-full bg-[#506c2a] flex items-center justify-center mb-4">
                        <span class="text-3xl font-bold text-white">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $customer->name }}</h2>
                    <p class="text-gray-600 mb-4">@{{ $customer->username }}</p>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $customer->email }}
                        </div>
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $customer->phone }}
                        </div>
                        @if($customer->location)
                        <div class="flex items-center justify-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $customer->location }}
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.customers.edit', $customer->_id) }}" class="flex-1 btn-primary text-center">
                            Edit Customer
                        </a>
                        <form method="POST" action="{{ route('admin.customers.destroy', $customer->_id) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="lg:col-span-2">
            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-lg text-gray-900">{{ $customer->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                            <p class="text-lg text-gray-900">@{{ $customer->username }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p class="text-lg text-gray-900">{{ $customer->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                            <p class="text-lg text-gray-900">{{ $customer->phone }}</p>
                        </div>
                        @if($customer->location)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Location</label>
                            <p class="text-lg text-gray-900">{{ $customer->location }}</p>
                        </div>
                        @endif
                        @if($customer->id_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">ID Number</label>
                            <p class="text-lg text-gray-900">{{ $customer->id_number }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Account Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Customer ID</label>
                            <p class="text-lg text-gray-900 font-mono">{{ $customer->_id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Registration Date</label>
                            <p class="text-lg text-gray-900">{{ $customer->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Registration Time</label>
                            <p class="text-lg text-gray-900">{{ $customer->created_at->format('g:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                            <p class="text-lg text-gray-900">{{ $customer->updated_at->format('F d, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Statistics -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Customer Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">0</div>
                            <div class="text-sm text-blue-600">Total Orders</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">$0.00</div>
                            <div class="text-sm text-green-600">Total Spent</div>
                        </div>
                        <div class="text-center p-4 bg-purple-50 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">0</div>
                            <div class="text-sm text-purple-600">Bookings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
