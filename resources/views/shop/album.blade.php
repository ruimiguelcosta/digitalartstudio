@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background">
    <header class="border-b border-border">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('shop.dashboard') }}">
                <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground px-4 py-2">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Voltar
                </button>
            </a>
            <a href="{{ route('shop.checkout') }}">
                <button type="button" class="relative inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Carrinho
                    @php
                        $cartCount = count($cart);
                    @endphp
                    @if($cartCount > 0)
                        <span class="ml-2 h-5 px-2 flex items-center justify-center rounded-full bg-primary text-primary-foreground text-xs">
                            {{ $cartCount }}
                        </span>
                    @endif
                </button>
            </a>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="font-serif text-4xl md:text-5xl font-bold mb-4 text-foreground">{{ $album->name }}</h1>
        @if($album->description)
            <p class="text-lg text-muted-foreground mb-8">{{ $album->description }}</p>
        @endif
        <p class="text-sm text-muted-foreground mb-8">Preço por foto: €10,00</p>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-md text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-destructive/10 border border-destructive/20 rounded-md text-destructive text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($album->photos->isEmpty())
            <div class="text-center py-12">
                <p class="text-muted-foreground">Este álbum ainda não possui fotografias.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                @foreach($album->photos as $index => $photo)
                    @php
                        $isInCart = collect($cart)->contains('photo_id', $photo->id);
                        $photoUrl = \Illuminate\Support\Facades\URL::signedRoute('album.photo', ['path' => base64_encode($photo->path)]);
                    @endphp
                    <div class="relative">
                        <div class="relative aspect-square overflow-hidden rounded-lg mb-2">
                            <img
                                src="{{ $photoUrl }}"
                                alt="Foto {{ $index + 1 }}"
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-muted-foreground text-sm">Foto {{ $index + 1 }}</span>
                            <form action="{{ $isInCart ? route('shop.cart.remove') : route('shop.cart.add') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                <input type="hidden" name="photo_index" value="{{ $index }}">
                                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 {{ $isInCart ? 'bg-primary text-primary-foreground hover:bg-primary/90' : 'border border-input bg-background hover:bg-accent hover:text-accent-foreground' }} px-3 py-1.5 text-xs">
                                    @if($isInCart)
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Selecionada
                                    @else
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Selecionar
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @php
                $albumCartCount = collect($cart)->where('album_id', $album->id)->count();
            @endphp
            @if($albumCartCount > 0)
                <div class="mt-8 p-4 bg-card border border-border rounded-lg">
                    <p class="text-foreground">{{ $albumCartCount }} foto(s) selecionada(s) deste álbum</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

