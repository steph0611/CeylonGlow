<div wire:poll.60s>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <a href="#booking" class="btn-primary inline-block">BOOK ONLINE</a>
        <div class="text-center md:text-right">
            <div class="font-semibold">{{ $phone }}</div>
            <div class="muted text-xs">{{ $address }}</div>
        </div>
    </div>
    <div class="flex items-center gap-4 justify-center md:justify-end mt-6 text-gray-600">
        @foreach($socialLinks as $social)
            <a href="{{ $social['url'] }}" class="hover:text-[#506c2a] transition-colors">
                <span class="i {{ $social['icon'] }}"></span>
            </a>
        @endforeach
    </div>
</div>
