@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background">
    <header class="border-b border-border">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="font-serif text-2xl font-bold text-foreground">
                {{ $album->name }}
            </h1>
            <div class="flex gap-3 items-center">
                <a href="{{ route('shop.checkout') }}">
                    <button type="button" class="relative inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @php
                            $cart = session('shop_cart', []);
                            $cartCount = count($cart);
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 h-5 w-5 flex items-center justify-center rounded-full bg-primary text-primary-foreground text-xs">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>
                </a>
                <form action="{{ route('shop.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground px-4 py-2">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-12">
        @if($album->photos->isEmpty())
            <div class="text-center py-12">
                <p class="text-muted-foreground text-lg">
                    Não tem fotografias disponíveis no momento.
                </p>
            </div>
        @else
            @php
                $firstPhoto = $album->photos->first();
            @endphp
            <div class="mb-8">
                <h2 class="font-serif text-3xl font-bold mb-2 text-foreground">{{ $album->name }}</h2>
                @if($album->description)
                    <p class="text-muted-foreground mb-6">{{ $album->description }}</p>
                @endif
            </div>

            @if($firstPhoto)
                <div class="mb-6">
                    <div class="relative aspect-[16/10] overflow-hidden rounded-lg">
                        <img 
                            src="{{ \Illuminate\Support\Facades\URL::signedRoute('album.photo', ['path' => base64_encode($firstPhoto->path)]) }}" 
                            alt="{{ $album->name }}"
                            class="w-full h-full object-cover"
                        />
                    </div>
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('shop.album', ['album' => $album->id]) }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 px-6 py-3">
                    Ver Álbum Completo
                </a>
            </div>
        @endif
    </main>
</div>
@endsection

