<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Membership - Ceylon Glow</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    @include('navigation-menu')

    <section class="relative w-full overflow-hidden h-64">
        <img src="{{ asset('images/news-2.jpg') }}" class="w-full h-full object-cover" alt="Membership">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white">Membership</h1>
        </div>
    </section>

    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($memberships as $membership)
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center relative transform hover:scale-105 transition-all duration-300">
                        @if($membership->sort_order == 2)
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                <span class="bg-[#506c2a] text-white px-4 py-1 rounded-full text-sm font-medium">Most Popular</span>
                            </div>
                        @endif
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $membership->name }}</h3>
                        <p class="text-gray-600 text-base mb-4">{{ $membership->description }}</p>
                        <div class="text-4xl font-bold text-[#506c2a] mt-4 mb-6">
                            ${{ number_format($membership->price, 0) }}
                            <span class="text-base font-normal text-gray-600">
                                /{{ $membership->duration_days == 30 ? 'month' : ($membership->duration_days == 365 ? 'year' : $membership->duration_days . ' days') }}
                            </span>
                        </div>
                        
                        @if($membership->benefits && count($membership->benefits) > 0)
                            <ul class="text-base text-gray-700 mt-6 space-y-3 mb-8">
                                @foreach($membership->benefits as $benefit)
                                    <li class="flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-left">{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <form method="POST" action="{{ route('membership.purchase', $membership->_id) }}" class="mt-6">
                            @csrf
                            <button type="submit" class="w-full bg-[#506c2a] text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-[#3d5220] transition-all duration-300 transform hover:scale-105 shadow-lg">
                                Join Now
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Membership Plans Available</h3>
                        <p class="text-gray-500">Please check back later for membership options.</p>
                    </div>
                @endforelse
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Compare Plans</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left">Feature</th>
                                <th class="p-3 text-left">Basic</th>
                                <th class="p-3 text-left">Plus</th>
                                <th class="p-3 text-left">Pro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([
                                ['Priority booking', true, true, true],
                                ['Discounts', true, true, true],
                                ['Quarterly freebies', false, true, true],
                                ['VIP support', false, false, true],
                                ['Exclusive events', false, false, true]
                            ] as $row)
                                <tr class="border-b">
                                    <td class="p-3">{{ $row[0] }}</td>
                                    <td class="p-3">{!! $row[1] ? '✔️' : '—' !!}</td>
                                    <td class="p-3">{!! $row[2] ? '✔️' : '—' !!}</td>
                                    <td class="p-3">{!! $row[3] ? '✔️' : '—' !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-3">FAQ</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="font-medium">Can I cancel anytime?</div>
                        <p class="text-gray-700">Yes, memberships are flexible and can be cancelled from your account.</p>
                    </div>
                    <div>
                        <div class="font-medium">Do plans include products?</div>
                        <p class="text-gray-700">Membership gives discounts and perks; products are purchased separately.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Include Professional Footer --}}
    @include('footer')

</body>
</html>


