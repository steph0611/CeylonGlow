<div wire:poll.10s>
    <div class="relative overflow-hidden">
        <div class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(-{{ $currentSlide * 100 }}%)">
            @forelse($products as $product)
                <div class="w-full md:w-1/2 lg:w-1/4 flex-shrink-0 px-2">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-40 object-cover" alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No Image</span>
                            </div>
                        @endif
                        <div class="p-4">
                            <h4 class="font-semibold text-sm mb-1">{{ $product->name }}</h4>
                            <p class="text-xs text-gray-600 mb-2">{{ Str::limit($product->description, 60) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-[#506c2a] font-bold">${{ $product->price }}</span>
                                <span class="text-xs text-gray-500">Qty: {{ $product->qty }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
