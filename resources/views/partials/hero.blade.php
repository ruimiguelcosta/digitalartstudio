<section class="relative h-screen flex items-center justify-center overflow-hidden pt-16">
    <div 
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('assets/hero-photography.jpg') }}'); filter: brightness(0.4);"
    ></div>
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto animate-fade-in">
        <h1 class="font-serif text-5xl md:text-7xl font-bold mb-6 text-foreground">
            António Braga
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-muted-foreground font-light">
            Capturando momentos inesquecíveis há mais de 30 anos
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button 
                onclick="document.getElementById('contact').scrollIntoView({ behavior: 'smooth' })"
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-lg font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 px-8 py-6 group"
            >
                Entre em Contacto
                <svg class="ml-2 group-hover:translate-x-1 transition-transform w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
            @php
                $hasAlbumAccess = session('album_access') && !request()->is('shop*');
            @endphp
            @if($hasAlbumAccess)
                <a 
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-lg font-semibold ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-8 py-6"
                >
                    Ver album privado
                </a>
            @endif
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-background to-transparent"></div>
</section>

