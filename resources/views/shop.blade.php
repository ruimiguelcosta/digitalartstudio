@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <svg class="w-16 h-16 mx-auto mb-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <h1 class="font-serif text-3xl font-bold text-foreground mb-2">
                António Braga Fotografia
            </h1>
            <p class="text-muted-foreground">Acesso aos seus álbuns</p>
        </div>

        <div class="bg-card border border-border rounded-lg p-8 shadow-lg">
            @if(session('error'))
                <div class="mb-4 p-3 bg-destructive/10 border border-destructive/20 rounded-md text-destructive text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('shop.login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="seu@email.com"
                        value="{{ old('email') }}"
                        required
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    />
                    @error('email')
                        <p class="text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="pin" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">PIN</label>
                    <input
                        id="pin"
                        name="pin"
                        type="password"
                        placeholder="Digite o PIN (12 caracteres)"
                        maxlength="12"
                        value="{{ old('pin') }}"
                        required
                        autofocus
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    />
                    @error('pin')
                        <p class="text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                    Entrar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

