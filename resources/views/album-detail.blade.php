<x-layouts.app>
    <div class="min-h-screen bg-background">
        <!-- Header -->
        <header class="border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-muted-foreground hover:text-foreground">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl logo-gradient">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold">Digital Art Studio</h1>
                            <p class="text-sm text-muted-foreground">Área do Fotógrafo</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-muted-foreground">
                            Olá, {{ auth()->user()->name }}
                        </div>
                        <button 
                            onclick="logout()"
                            class="btn-secondary"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sair
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Livewire Photo Manager Component -->
            <livewire:albums.photo-manager :album="$album" />
        </main>
    </div>

    <script>
        function logout() {
            fetch('/api/auth/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            }).then(() => {
                window.location.href = '{{ route("auth") }}';
            }).catch(() => {
                window.location.href = '{{ route("auth") }}';
            });
        }
    </script>
</x-layouts.app>