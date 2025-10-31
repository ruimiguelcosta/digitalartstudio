@php
    $albums = [
        [
            'id' => 'casamentos',
            'title' => 'Casamentos',
            'coverPhoto' => asset('assets/wedding-photo.jpg'),
        ],
        [
            'id' => 'danca',
            'title' => 'Dança',
            'coverPhoto' => asset('assets/dance-photo.jpg'),
        ],
        [
            'id' => 'teatro',
            'title' => 'Teatro',
            'coverPhoto' => asset('assets/theater-photo.jpg'),
        ],
        [
            'id' => 'festas',
            'title' => 'Festas',
            'coverPhoto' => asset('assets/party-photo.jpg'),
        ],
    ];
@endphp

<section id="portfolio" class="py-24 px-4 bg-secondary">
    <div class="max-w-6xl mx-auto">
        <h2 class="font-serif text-4xl md:text-5xl font-bold text-center mb-16 text-foreground">
            Portfolio
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($albums as $album)
                <a 
                    href="{{ route('albums.show', $album['id']) }}"
                    class="relative overflow-hidden rounded-lg aspect-[4/5] group cursor-pointer"
                >
                    <img 
                        src="{{ $album['coverPhoto'] }}" 
                        alt="{{ $album['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-background/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                        <h3 class="font-serif text-2xl font-bold text-foreground p-6">
                            {{ $album['title'] }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

