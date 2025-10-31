@php
    $photos = $album->photos->map(fn($photo) => [
        'url' => \Illuminate\Support\Facades\URL::signedRoute('album.photo', ['path' => base64_encode($photo->path)]),
    ]);
@endphp

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('index') }}">
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground px-4 py-2">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar ao início
                </button>
            </a>
        </div>

        <h1 class="font-serif text-4xl md:text-5xl font-bold mb-4 text-foreground">{{ $album->name }}</h1>
        @if($album->description)
            <p class="text-lg text-muted-foreground mb-8">{{ $album->description }}</p>
        @endif

        @if($album->photos->isEmpty())
            <div class="text-center py-12">
                <p class="text-muted-foreground">Este álbum ainda não possui fotografias.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($album->photos as $index => $photo)
                    <button
                        onclick="openSlideshow({{ $index }})"
                        class="relative overflow-hidden rounded-lg aspect-square group cursor-pointer"
                    >
                        <img 
                            src="{{ \Illuminate\Support\Facades\URL::signedRoute('album.photo', ['path' => base64_encode($photo->path)]) }}" 
                            alt="Foto {{ $index + 1 }}"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                        />
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                    </button>
                @endforeach
            </div>

            <div id="slideshow" class="hidden fixed inset-0 z-50 bg-black/95 flex items-center justify-center">
                <button
                    onclick="closeSlideshow()"
                    class="absolute top-4 right-4 text-white hover:text-primary z-10"
                >
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <button
                    onclick="previousPhoto()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-primary z-10"
                    id="prev-btn"
                >
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button
                    onclick="nextPhoto()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-white hover:text-primary z-10"
                    id="next-btn"
                >
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div class="relative max-w-7xl mx-auto px-16">
                    <img 
                        id="slideshow-image"
                        src=""
                        alt="Foto"
                        class="max-h-screen max-w-full object-contain"
                    />
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white text-sm">
                        <span id="photo-counter"></span>
                    </div>
                </div>
            </div>

            <script>
                const photos = @json($photos);
                let currentPhotoIndex = 0;

                function openSlideshow(index) {
                    currentPhotoIndex = index;
                    document.getElementById('slideshow').classList.remove('hidden');
                    updatePhoto();
                    document.body.style.overflow = 'hidden';
                }

                function closeSlideshow() {
                    document.getElementById('slideshow').classList.add('hidden');
                    document.body.style.overflow = '';
                }

                function updatePhoto() {
                    const photo = photos[currentPhotoIndex];
                    document.getElementById('slideshow-image').src = photo.url;
                    document.getElementById('photo-counter').textContent = `${currentPhotoIndex + 1} / ${photos.length}`;
                    
                    document.getElementById('prev-btn').disabled = currentPhotoIndex === 0;
                    document.getElementById('next-btn').disabled = currentPhotoIndex === photos.length - 1;
                }

                function nextPhoto() {
                    if (currentPhotoIndex < photos.length - 1) {
                        currentPhotoIndex++;
                        updatePhoto();
                    }
                }

                function previousPhoto() {
                    if (currentPhotoIndex > 0) {
                        currentPhotoIndex--;
                        updatePhoto();
                    }
                }

                document.addEventListener('keydown', function(e) {
                    if (!document.getElementById('slideshow').classList.contains('hidden')) {
                        if (e.key === 'ArrowRight') {
                            nextPhoto();
                        } else if (e.key === 'ArrowLeft') {
                            previousPhoto();
                        } else if (e.key === 'Escape') {
                            closeSlideshow();
                        }
                    }
                });
            </script>
        @endif
    </div>
</div>
@endsection


