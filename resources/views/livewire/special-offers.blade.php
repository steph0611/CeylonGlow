<div wire:poll.20s>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
        @foreach($offers as $index => $offer)
            @if($offer['position'] === 'large')
                <div class="relative">
                    <img src="{{ asset($offer['image']) }}" class="w-full h-64 object-cover rounded" alt="{{ $offer['title'] }}">
                    <div class="absolute left-4 bottom-4 bg-white/90 rounded px-4 py-2 text-sm">
                        <span class="font-semibold">{{ $offer['title'] }}</span>
                    </div>
                </div>
            @else
                @if($index === 1)
                    <div class="grid grid-cols-1 gap-6">
                @endif
                <img src="{{ asset($offer['image']) }}" class="w-full h-28 object-cover rounded" alt="{{ $offer['title'] }}">
                @if($index === count($offers) - 1)
                    </div>
                @endif
            @endif
        @endforeach
    </div>
</div>
