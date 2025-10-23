<x-layouts.app>
    <div class="min-h-screen">
        <header class="border-b border-border/50 bg-card/50 backdrop-blur-sm">
            <div class="container mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl logo-gradient flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-foreground">PhotoEvents</h1>
                </div>
            </div>
        </header>

        <main class="container mx-auto px-4 py-16">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <h2 class="text-4xl font-bold tracking-tight mb-4">
                    Plataforma de Venda de Fotos de Eventos
                </h2>
                <p class="text-xl text-muted-foreground">
                    Para fotógrafos e clientes partilharem e adquirirem fotografias de eventos
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="card-elevated rounded-lg hover:shadow-elegant transition-all duration-300">
                    <div class="p-6 text-center">
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 rounded-2xl logo-gradient flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-semibold mb-2">Sou Fotógrafo</h3>
                        <p class="text-muted-foreground mb-6">
                            Faça upload e gerir as suas fotos de eventos
                        </p>
                        <a href="{{ route('auth') }}" class="btn-primary inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-11 px-8 w-full">
                            Aceder como Fotógrafo
                        </a>
                    </div>
                </div>

                <div class="card-elevated rounded-lg hover:shadow-elegant transition-all duration-300">
                    <div class="p-6 text-center">
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 rounded-2xl logo-gradient flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-semibold mb-2">Sou Cliente</h3>
                        <p class="text-muted-foreground mb-6">
                            Aceder ao álbum do meu evento e comprar fotos
                        </p>
                        <a href="{{ route('client.auth') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-11 px-8 w-full shadow-soft">
                            Aceder ao Meu Álbum
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layouts.app>

