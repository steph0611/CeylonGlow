@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Memberships</h1>
            <p class="text-gray-600">Manage your Ceylon Glow membership subscriptions</p>
        </div>

        <!-- Active Membership Card -->
        @if($activeMembership)
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $activeMembership->membership->name }} Membership</h2>
                            <p class="text-gray-600">Active since {{ $activeMembership->purchased_at->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-500">Expires on {{ $activeMembership->expires_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-green-600">Active</div>
                        <div class="text-sm text-gray-500">{{ $activeMembership->days_remaining }} days remaining</div>
                    </div>
                </div>

                <!-- Membership Benefits -->
                @if($activeMembership->membership->benefits && count($activeMembership->membership->benefits) > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Your Benefits:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($activeMembership->membership->benefits as $benefit)
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('services') }}" class="bg-[#506c2a] text-white px-6 py-2 rounded-lg hover:bg-[#3d5220] transition-colors">
                        Book Services
                    </a>
                    <form method="POST" action="{{ route('membership.cancel', $activeMembership->_id) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors" 
                                onclick="return confirm('Are you sure you want to cancel your membership?')">
                            Cancel Membership
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- No Active Membership -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-8 text-center mb-8">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">No Active Membership</h2>
                <p class="text-gray-600 mb-4">You don't have an active membership. Purchase one to access exclusive benefits and book services.</p>
                <a href="{{ route('membership') }}" class="bg-[#506c2a] text-white px-6 py-3 rounded-lg hover:bg-[#3d5220] transition-colors">
                    View Membership Plans
                </a>
            </div>
        @endif

        <!-- Membership History -->
        <div class="bg-white shadow-sm rounded-xl">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Membership History</h2>
                <p class="text-gray-600 text-sm mt-1">View all your past and current memberships</p>
            </div>

            @if($membershipHistory->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Membership</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchased</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expires</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($membershipHistory as $purchase)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $purchase->membership->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $purchase->membership->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($purchase->isActive())
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @elseif($purchase->isExpired())
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Expired
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($purchase->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $purchase->purchased_at ? $purchase->purchased_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $purchase->expires_at ? $purchase->expires_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($purchase->amount_paid, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($purchase->isActive())
                                            <form method="POST" action="{{ route('membership.cancel', $purchase->_id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Are you sure you want to cancel this membership?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        @elseif($purchase->isExpired())
                                            <form method="POST" action="{{ route('membership.renew', $purchase->_id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                    Renew
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">No actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Membership History</h3>
                    <p class="text-gray-500">You haven't purchased any memberships yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
