<div wire:poll.10s>
    <div class="relative overflow-hidden">
        <div class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(-{{ $currentSlide * 100 }}%)">
            @forelse($services as $service)
                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-2">
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
                            <a href="#booking" class="inline-block mt-3 bg-[#506c2a] text-white px-4 py-2 rounded-full text-sm hover:bg-[#3e541f] transition-colors">Book Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="w-full text-center py-8">
                    <p class="text-gray-500">No services available at the moment.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Carousel Navigation -->
        <button wire:click="prevSlide" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button wire:click="nextSlide" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
    
    <!-- Carousel Indicators -->
    <div class="flex justify-center mt-4 space-x-2">
        @for($i = 0; $i < $totalSlides; $i++)
            <button wire:click="goToSlide({{ $i }})" class="w-2 h-2 rounded-full transition-colors {{ $currentSlide === $i ? 'bg-[#506c2a]' : 'bg-gray-300' }}"></button>
        @endfor
    </div>
</div>
