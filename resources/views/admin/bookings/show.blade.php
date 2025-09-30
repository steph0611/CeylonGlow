@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Booking Details</h2>
                    <a href="{{ route('admin.bookings.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to Bookings</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="text-sm text-gray-900">{{ $booking->customer_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="text-sm text-gray-900">{{ $booking->customer_email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="text-sm text-gray-900">{{ $booking->customer_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Service Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Service Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service</label>
                                <p class="text-sm text-gray-900">{{ $booking->service_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <p class="text-sm text-gray-900">${{ number_format($booking->service_price, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Booking Details</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Time</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_time)->format('g:i A') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold mb-4">Notes</h3>
                        <div>
                            <p class="text-sm text-gray-900">{{ $booking->notes ?: 'No notes provided' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('admin.bookings.edit', $booking->_id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit Booking</a>
                    <form action="{{ route('admin.bookings.destroy', $booking->_id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

