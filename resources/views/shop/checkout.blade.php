@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background">
    <header class="border-b border-border">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <a href="{{ route('shop.dashboard') }}">
                <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground px-4 py-2">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Voltar ao Dashboard
                </button>
            </a>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="font-serif text-4xl font-bold mb-8 text-foreground">Finalizar Encomenda</h1>

        @if(session('error'))
            <div class="mb-4 p-3 bg-destructive/10 border border-destructive/20 rounded-md text-destructive text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if(empty($cart))
            <div class="text-center py-12">
                <p class="text-muted-foreground text-lg mb-6">O seu carrinho está vazio.</p>
                <a href="{{ route('shop.dashboard') }}">
                    <button type="button" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 px-6 py-3">
                        Voltar aos Álbuns
                    </button>
                </a>
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-serif font-bold mb-4 text-foreground">Fotos Selecionadas</h2>
                    <div class="space-y-4">
                        @php
                            $photos = \App\Models\Photo::query()
                                ->whereIn('id', collect($cart)->pluck('photo_id'))
                                ->get()
                                ->keyBy('id');
                            $totalPrice = count($cart) * 10;
                        @endphp
                        @foreach($cart as $item)
                            @php
                                $photo = $photos->get($item['photo_id'] ?? null);
                                $photoIndex = $item['photo_index'] ?? 0;
                            @endphp
                            @if($photo)
                                <div class="flex gap-4 items-center bg-card border border-border rounded-lg p-3">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\URL::signedRoute('album.photo', ['path' => base64_encode($photo->path)]) }}"
                                        alt="Foto {{ $photoIndex + 1 }}"
                                        class="w-20 h-20 object-cover rounded"
                                    />
                                    <div class="flex-1">
                                        <p class="text-sm text-muted-foreground">Foto {{ $photoIndex + 1 }}</p>
                                        <p class="font-semibold text-foreground">€10.00</p>
                                    </div>
                                    <form action="{{ route('shop.cart.remove') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground p-2">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-6 pt-6 border-t border-border">
                        <div class="flex justify-between text-xl font-bold">
                            <span>Total:</span>
                            <span>€{{ number_format($totalPrice, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-serif font-bold mb-4 text-foreground">Dados de Contacto</h2>
                    <form action="{{ route('shop.checkout.process') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium leading-none">Email</label>
                            <input
                                id="email"
                                type="email"
                                value="{{ $userEmail }}"
                                disabled
                                class="flex h-10 w-full rounded-md border border-input bg-muted px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium leading-none">Nome Completo *</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                placeholder="O seu nome"
                                value="{{ old('name') }}"
                                required
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('name')
                                <p class="text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium leading-none">Telemóvel *</label>
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                placeholder="+351 xxx xxx xxx"
                                value="{{ old('phone') }}"
                                required
                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('phone')
                                <p class="text-sm text-destructive">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-8 w-full">
                            Confirmar Encomenda
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

