@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-background flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-card border border-border rounded-lg shadow-lg p-6">
        <h2 class="font-serif text-2xl font-bold mb-6 text-foreground text-center">Login</h2>
        
        <form action="{{ route('login.post') }}" method="POST" id="login-form">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-foreground mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        value="{{ old('email') }}"
                        class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        placeholder="seu@email.com"
                    />
                    @error('email')
                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="pin" class="block text-sm font-medium text-foreground mb-2">PIN</label>
                    <input 
                        type="password" 
                        id="pin" 
                        name="pin" 
                        required
                        maxlength="6"
                        pattern="[0-9]{6}"
                        inputmode="numeric"
                        class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        placeholder="000000"
                    />
                    @error('pin')
                        <p class="mt-1 text-sm text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                
                @if(session('error'))
                    <p class="text-sm text-destructive">{{ session('error') }}</p>
                @endif
                
                <button 
                    type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 px-4 py-2"
                >
                    Entrar
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('index') }}" class="text-sm text-muted-foreground hover:text-foreground">
                ← Voltar ao site
            </a>
        </div>
    </div>
</div>
@endsection

