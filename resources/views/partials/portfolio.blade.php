@php
    use App\Models\Gallery;
    
    $galleries = Gallery::query()
        ->where('active', true)
        ->orderBy('order')
        ->get();
@endphp

<section id="portfolio" class="py-24 px-4 bg-secondary">
    <div class="max-w-6xl mx-auto">
        <h2 class="font-serif text-4xl md:text-5xl font-bold text-center mb-16 text-foreground">
            Portfolio
        </h2>
        @if($galleries->isEmpty())
            <p class="text-center text-foreground/60">Nenhuma galeria disponível no momento.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($galleries as $gallery)
                    <a 
                        href="#"
                        class="relative overflow-hidden rounded-lg aspect-[4/5] group cursor-pointer"
                    >
                        @if($gallery->cover_photo_url)
                            <img 
                                src="{{ $gallery->cover_photo_url }}" 
                                alt="{{ $gallery->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />
                            <div class="w-full h-full bg-foreground/10 flex items-center justify-center" style="display: none;">
                                <span class="text-foreground/40">Erro ao carregar imagem</span>
                            </div>
                        @else
                            <div class="w-full h-full bg-foreground/10 flex items-center justify-center">
                                <span class="text-foreground/40">Sem imagem</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-background/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <h3 class="font-serif text-2xl font-bold text-foreground p-6">
                                {{ $gallery->name }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

