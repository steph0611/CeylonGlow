<div wire:poll.5s>
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl font-semibold mb-4">Our Services</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $service)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" class="w-full h-40 object-cover" alt="{{ $service->name }}">
                    @else
                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold">{{ $service->name }}</h3>
                        <div class="text-[#506c2a] font-semibold mt-1">${{ $service->price }}</div>
                        <div class="text-sm text-gray-500 mt-1">{{ $service->duration }} • {{ $service->category }}</div>
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($service->description, 100) }}</p>
                        <a href="{{ route('contact') }}?service={{ $service->_id }}" class="inline-block mt-3 bg-[#506c2a] text-white px-4 py-2 rounded-full text-sm hover:bg-[#3e541f] transition-colors">Book Now</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No services available at the moment.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">{{ $services->links() }}</div>
    </div>
</div>


