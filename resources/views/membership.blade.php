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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['Basic','For occasional visits', '29', ['Member-only discounts','Priority booking','Birthday perk']],
                    ['Plus','Extra perks and savings', '59', ['Everything in Basic','Quarterly freebies','Early access']],
                    ['Pro','Best value for regulars', '99', ['Everything in Plus','VIP support','Exclusive events']]
                ] as $tier)
                    <div class="bg-white rounded-xl shadow p-6 text-center">
                        <h3 class="text-lg font-semibold">{{ $tier[0] }}</h3>
                        <p class="text-gray-600 text-sm">{{ $tier[1] }}</p>
                        <div class="text-3xl font-bold text-[#506c2a] mt-3">${{ $tier[2] }}<span class="text-base font-normal text-gray-600">/mo</span></div>
                        <ul class="text-sm text-gray-700 mt-4 space-y-1">
                            @foreach($tier[3] as $benefit)
                                <li>{{ $benefit }}</li>
                            @endforeach
                        </ul>
                        <a href="#booking" class="inline-block mt-5 bg-[#506c2a] text-white px-5 py-2.5 rounded-full text-sm">Join Now</a>
                    </div>
                @endforeach
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

</body>
</html>


