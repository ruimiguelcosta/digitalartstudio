<div>
    <!-- Search and Filters -->
    <div class="mb-6 space-y-4">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Pesquisar álbuns..."
                    class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                />
            </div>
            <div class="flex gap-2">
                <select wire:model.live="isPublic" class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <option value="">Todos</option>
                    <option value="1">Publicados</option>
                    <option value="0">Rascunhos</option>
                </select>
                <button 
                    wire:click="openCreateDialog"
                    class="btn-primary inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Novo Álbum
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Albums Grid -->
    @if($albums->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($albums as $album)
                <div class="card-elevated rounded-lg overflow-hidden hover:shadow-lg transition-shadow cursor-pointer" onclick="window.location.href='{{ route('album.detail', $album->id) }}'">
                    <div class="aspect-video bg-gray-100 relative group">
                        @if($album->photos->count() > 0)
                            <img 
                                src="{{ $album->photos->first()->getUrl() }}" 
                                alt="{{ $album->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                            />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($album->is_public)
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-primary text-primary-foreground">
                                    Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">
                                    Rascunho
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ $album->title }}</h3>
                        
                        @if($album->description)
                            <p class="text-muted-foreground text-sm mb-3 line-clamp-2">{{ $album->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between text-sm text-muted-foreground mb-4">
                            <span>{{ $album->event_start_date ? $album->event_start_date->format('d/m/Y') : 'Sem data' }}</span>
                            <span>{{ $album->photos->count() }} {{ $album->photos->count() === 1 ? 'foto' : 'fotos' }}</span>
                        </div>
                        
                        <div class="flex gap-2">
                            <a 
                                href="{{ route('album.detail', $album->id) }}" 
                                class="btn-secondary flex-1 text-center hover:bg-gray-100 transition-colors"
                                onclick="event.stopPropagation()"
                            >
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Detalhes
                            </a>
                            <button 
                                wire:click="deleteAlbum({{ $album->id }})"
                                wire:confirm="Tem certeza que deseja excluir este álbum?"
                                class="btn-destructive px-3 hover:bg-red-700 transition-colors"
                                onclick="event.stopPropagation()"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $albums->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl logo-gradient mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">Nenhum álbum encontrado</h3>
            <p class="text-muted-foreground mb-4">
                @if($search || $isPublic !== null)
                    Tente ajustar os filtros de pesquisa.
                @else
                    Crie seu primeiro álbum para começar a organizar suas fotos.
                @endif
            </p>
            @if(!$search && $isPublic === null)
                <button 
                    wire:click="openCreateDialog"
                    class="btn-primary inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Criar Primeiro Álbum
                </button>
            @endif
        </div>
    @endif

    <!-- Create Album Modal -->
    @if($showCreateDialog)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-md w-full max-h-[90vh] overflow-y-auto border-2 border-primary">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Criar Novo Álbum</h2>
                        <button 
                            wire:click="closeCreateDialog"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="createAlbum" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Título *</label>
                            <input 
                                type="text" 
                                wire:model="newAlbum.title"
                                class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="Nome do evento"
                            />
                            @error('newAlbum.title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Descrição</label>
                            <textarea 
                                wire:model="newAlbum.description"
                                rows="3"
                                class="input-focus flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                placeholder="Descrição opcional do evento"
                            ></textarea>
                            @error('newAlbum.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Data de Início *</label>
                                <input 
                                    type="date" 
                                    wire:model="newAlbum.event_start_date"
                                    class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                />
                                @error('newAlbum.event_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-1">Data de Fim</label>
                                <input 
                                    type="date" 
                                    wire:model="newAlbum.event_end_date"
                                    class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                />
                                @error('newAlbum.event_end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button"
                                wire:click="closeCreateDialog"
                                class="btn-secondary flex-1"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="btn-primary flex-1 inline-flex items-center justify-center px-6 py-3 text-white font-medium rounded-lg"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Criar Álbum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>