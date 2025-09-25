<div wire:poll.30s>
    <div class="section-card p-8 md:p-10">
        <h2 class="text-center text-2xl font-semibold mb-8">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center text-sm">
            @foreach($features as $feature)
                <div>
                    <div class="text-4xl text-gray-400 mb-2">{{ $feature['number'] }}</div>
                    <div class="font-semibold mb-1">{{ $feature['title'] }}</div>
                    <p class="muted">{{ $feature['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
