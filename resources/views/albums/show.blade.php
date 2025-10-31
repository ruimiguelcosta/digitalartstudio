@php
    $albums = [
        'casamentos' => [
            'title' => 'Casamentos',
            'description' => 'Momentos únicos e inesquecíveis do dia mais importante das vossas vidas. Cada fotografia conta uma história de amor, emoção e celebração.',
            'photos' => [
                ['src' => asset('assets/wedding-photo.jpg'), 'alt' => 'Fotografia de casamento - Cerimônia'],
                ['src' => asset('assets/wedding-photo.jpg'), 'alt' => 'Fotografia de casamento - Noivos'],
                ['src' => asset('assets/wedding-photo.jpg'), 'alt' => 'Fotografia de casamento - Festa'],
            ],
        ],
        'danca' => [
            'title' => 'Dança',
            'description' => 'Capturando o movimento, a expressão e a energia dos bailarinos. Cada imagem revela a arte em movimento e a paixão pela dança.',
            'photos' => [
                ['src' => asset('assets/dance-photo.jpg'), 'alt' => 'Fotografia de dança - Performance'],
                ['src' => asset('assets/dance-photo.jpg'), 'alt' => 'Fotografia de dança - Ensaio'],
                ['src' => asset('assets/dance-photo.jpg'), 'alt' => 'Fotografia de dança - Espetáculo'],
            ],
        ],
        'teatro' => [
            'title' => 'Teatro',
            'description' => 'Registando a magia do palco, a intensidade dramática e os momentos únicos das produções teatrais.',
            'photos' => [
                ['src' => asset('assets/theater-photo.jpg'), 'alt' => 'Fotografia de teatro - Cena dramática'],
                ['src' => asset('assets/theater-photo.jpg'), 'alt' => 'Fotografia de teatro - Atores em cena'],
                ['src' => asset('assets/theater-photo.jpg'), 'alt' => 'Fotografia de teatro - Momento especial'],
            ],
        ],
        'festas' => [
            'title' => 'Festas',
            'description' => 'Celebrações cheias de alegria, diversão e memórias especiais. Capturo a energia e os momentos únicos de cada evento.',
            'photos' => [
                ['src' => asset('assets/party-photo.jpg'), 'alt' => 'Fotografia de festa - Celebração'],
                ['src' => asset('assets/party-photo.jpg'), 'alt' => 'Fotografia de festa - Diversão'],
                ['src' => asset('assets/party-photo.jpg'), 'alt' => 'Fotografia de festa - Momento especial'],
            ],
        ],
    ];

    $album = $albums[$id] ?? null;
@endphp

@extends('layouts.app')

@section('content')
@if(!$album)
    <div class="min-h-screen bg-background flex items-center justify-center px-4">
        <div class="text-center">
            <h1 class="text-4xl font-serif font-bold mb-4 text-foreground">Álbum não encontrado</h1>
            <a href="{{ route('index') }}">
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar ao início
                </button>
            </a>
        </div>
    </div>
@else
    <div class="min-h-screen bg-background">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <a href="{{ route('index') }}#portfolio">
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground px-4 py-2 mb-8">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar ao Portfolio
                </button>
            </a>

            <h1 class="font-serif text-4xl md:text-5xl font-bold mb-4 text-foreground">
                {{ $album['title'] }}
            </h1>
            <p class="text-lg text-muted-foreground mb-12 max-w-3xl">
                {{ $album['description'] }}
            </p>

            <div class="relative w-full">
                <div class="overflow-hidden rounded-lg">
                    <div class="flex gap-4" id="carousel-content">
                        @foreach($album['photos'] as $index => $photo)
                            <div class="min-w-full relative aspect-[16/10] overflow-hidden rounded-lg {{ $index === 0 ? '' : 'hidden' }}" data-slide="{{ $index }}">
                                <img
                                    src="{{ $photo['src'] }}"
                                    alt="{{ $photo['alt'] }}"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        @endforeach
                    </div>
                </div>
                @if(count($album['photos']) > 1)
                    <button 
                        onclick="previousSlide()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 inline-flex items-center justify-center rounded-full w-10 h-10 border border-input bg-background hover:bg-accent hover:text-accent-foreground"
                        id="prev-btn"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="sr-only">Previous slide</span>
                    </button>
                    <button 
                        onclick="nextSlide()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 inline-flex items-center justify-center rounded-full w-10 h-10 border border-input bg-background hover:bg-accent hover:text-accent-foreground"
                        id="next-btn"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="sr-only">Next slide</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if(count($album['photos']) > 1)
    <script>
        let currentSlide = 0;
        const totalSlides = {{ count($album['photos']) }};

        function showSlide(index) {
            const slides = document.querySelectorAll('[data-slide]');
            slides.forEach((slide, i) => {
                slide.classList.toggle('hidden', i !== index);
            });
            document.getElementById('prev-btn').disabled = index === 0;
            document.getElementById('next-btn').disabled = index === totalSlides - 1;
        }

        function nextSlide() {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                showSlide(currentSlide);
            }
        }

        function previousSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                showSlide(currentSlide);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSlide(0);
        });
    </script>
    @endif
@endif
@endsection

