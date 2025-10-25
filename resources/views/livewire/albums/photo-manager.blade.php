<div>
    <!-- Album Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">{{ $album->title }}</h1>
                <div class="flex items-center space-x-4 mt-2 text-muted-foreground">
                    <span>{{ $album->event_start_date ? $album->event_start_date->format('d/m/Y') : 'Sem data' }}</span>
                    <span>•</span>
                    <span>{{ count($photos) }} {{ count($photos) === 1 ? 'foto' : 'fotos' }}</span>
                    <span>•</span>
                    <span>
                        @if($album->is_public)
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-primary text-primary-foreground">
                                Publicado
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">
                                Rascunho
                            </span>
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                @if(!$album->is_public)
                    <button 
                        wire:click="publishAlbum"
                        class="btn-primary"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Publicar Álbum
                    </button>
                @endif
                
                <button 
                    wire:click="openUploadModal"
                    class="btn-secondary"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Adicionar Fotos
                </button>
            </div>
        </div>

        @if($album->description)
            <div class="bg-muted/50 rounded-lg p-4">
                <p class="text-muted-foreground">{{ $album->description }}</p>
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Photos Grid -->
    @if(count($photos) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($photos as $photo)
                <div class="group relative aspect-square bg-gray-100 rounded-lg overflow-hidden">
                    <img 
                        src="{{ Storage::disk('public')->url('photos/' . $photo['filename']) }}" 
                        alt="{{ $photo['original_name'] }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                    />
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex space-x-2">
                            <button 
                                wire:click="deletePhoto({{ $photo['id'] }})"
                                wire:confirm="Tem certeza que deseja excluir esta foto?"
                                class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Order Badge -->
                    <div class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                        {{ $photo['order'] }}
                    </div>
                </div>
            @endforeach
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
            <h3 class="text-lg font-semibold mb-2">Nenhuma foto adicionada</h3>
            <p class="text-muted-foreground mb-4">
                Adicione fotos ao seu álbum para começar a organizá-las.
            </p>
            <button 
                wire:click="openUploadModal"
                class="btn-primary inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Adicionar Primeiras Fotos
            </button>
        </div>
    @endif

    <!-- Album Access Log (Admin Only) -->
    @if(auth()->user()->is_admin && $accesses->count() > 0)
        <div class="mt-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold tracking-tight">Registo de Acessos</h2>
                <div class="text-sm text-muted-foreground">
                    {{ $accesses->count() }} {{ $accesses->count() === 1 ? 'acesso' : 'acessos' }} registados
                </div>
            </div>
            
            <div class="card-elevated rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-muted/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Utilizador
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Data/Hora
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    IP
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">
                                    Dispositivo
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @foreach($accesses as $access)
                                <tr class="hover:bg-muted/25 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($access->user)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-primary">
                                                            {{ substr($access->user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-foreground">
                                                        {{ $access->user->name }}
                                                    </div>
                                                    <div class="text-sm text-muted-foreground">
                                                        {{ $access->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-foreground">
                                                        Visitante Anónimo
                                                    </div>
                                                    <div class="text-sm text-muted-foreground">
                                                        Não autenticado
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-foreground">
                                            {{ $access->accessed_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-muted-foreground">
                                            {{ $access->accessed_at->format('H:i:s') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-muted-foreground">
                                        {{ $access->ip_address ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-muted-foreground">
                                        @if($access->user_agent)
                                            @php
                                                $browser = 'Unknown';
                                                $os = 'Unknown';
                                                
                                                if (strpos($access->user_agent, 'Chrome') !== false) {
                                                    $browser = 'Chrome';
                                                } elseif (strpos($access->user_agent, 'Firefox') !== false) {
                                                    $browser = 'Firefox';
                                                } elseif (strpos($access->user_agent, 'Safari') !== false) {
                                                    $browser = 'Safari';
                                                } elseif (strpos($access->user_agent, 'Edge') !== false) {
                                                    $browser = 'Edge';
                                                }
                                                
                                                if (strpos($access->user_agent, 'Windows') !== false) {
                                                    $os = 'Windows';
                                                } elseif (strpos($access->user_agent, 'Mac') !== false) {
                                                    $os = 'macOS';
                                                } elseif (strpos($access->user_agent, 'Linux') !== false) {
                                                    $os = 'Linux';
                                                } elseif (strpos($access->user_agent, 'Android') !== false) {
                                                    $os = 'Android';
                                                } elseif (strpos($access->user_agent, 'iOS') !== false) {
                                                    $os = 'iOS';
                                                }
                                            @endphp
                                            <div class="text-sm">{{ $browser }}</div>
                                            <div class="text-xs text-muted-foreground">{{ $os }}</div>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Upload Modal -->
    @if($showUploadModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">Adicionar Fotos</h2>
                        <button 
                            wire:click="closeUploadModal"
                            class="text-gray-400 hover:text-gray-600"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="uploadPhotos" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Selecionar Fotos</label>
                            <input 
                                type="file" 
                                wire:model="uploadedPhotos"
                                multiple
                                accept="image/*"
                                class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            />
                            @error('uploadedPhotos.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-muted-foreground mt-1">
                                Máximo 10MB por foto. Formatos aceitos: JPG, PNG, GIF, WebP
                            </p>
                        </div>

                        @if($uploadedPhotos)
                            <div class="space-y-2">
                                <h3 class="text-sm font-medium">Fotos Selecionadas:</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($uploadedPhotos as $index => $photo)
                                        <div class="text-xs text-muted-foreground">
                                            {{ $photo->getClientOriginalName() }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="button"
                                wire:click="closeUploadModal"
                                class="btn-secondary flex-1"
                                @if($isUploading) disabled @endif
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="btn-primary flex-1"
                                @if($isUploading) disabled @endif
                            >
                                @if($isUploading)
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Fazendo Upload...
                                @else
                                    Fazer Upload
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>