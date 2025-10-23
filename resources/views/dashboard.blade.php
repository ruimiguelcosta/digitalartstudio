<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background">
        <header class="border-b border-border/50 bg-card/50 backdrop-blur-sm sticky top-0 z-10">
            <div class="container mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">PhotoEvents</h1>
                        <p class="text-sm text-muted-foreground">Dashboard do Fotógrafo</p>
                    </div>
                </div>
                <button onclick="handleLogout()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-purple-600 text-white hover:bg-purple-700 h-10 px-4 py-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Sair
                </button>
            </div>
        </header>

        <main class="container mx-auto px-4 py-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Meus Álbuns</h2>
                    <p class="text-muted-foreground mt-1">Gerir os seus eventos e fotos</p>
                </div>
                
                <button onclick="openCreateDialog()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-purple-600 text-white hover:bg-purple-700 h-10 px-4 py-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Novo Álbum
                </button>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="border border-dashed rounded-lg">
                <div class="flex flex-col items-center justify-center py-16 px-6">
                    <svg class="w-16 h-16 text-muted-foreground/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Nenhum álbum criado</h3>
                    <p class="text-muted-foreground text-center mb-6 max-w-md">
                        Comece por criar o seu primeiro álbum de evento para fazer upload de fotos
                    </p>
                    <button onclick="openCreateDialog()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-purple-600 text-white hover:bg-purple-700 h-10 px-4 py-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Criar Primeiro Álbum
                    </button>
                </div>
            </div>

            <!-- Albums Grid -->
            <div id="albums-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                <!-- Albums will be dynamically added here -->
            </div>
        </main>
    </div>

    <!-- Create Album Dialog -->
    <div id="create-dialog" class="fixed inset-0 z-50 bg-black/80 hidden">
        <div class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-white p-6 shadow-lg duration-200 sm:rounded-lg">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold leading-none tracking-tight text-gray-900">Criar Novo Álbum</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Adicione os detalhes do evento para criar um novo álbum
                        </p>
                    </div>
                    <button onclick="closeCreateDialog()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="create-album-form" class="space-y-4">
                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium text-foreground">Título do Evento</label>
                    <input
                        id="title"
                        name="title"
                        placeholder="Ex: Casamento João & Maria"
                        required
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    />
                </div>
                <div class="space-y-2">
                    <label for="date" class="text-sm font-medium text-foreground">Data do Evento</label>
                    <div class="relative">
                        <input
                            id="date"
                            name="date"
                            type="date"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        />
                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="managerEmail" class="text-sm font-medium text-foreground">Email do Gestor do Álbum</label>
                    <input
                        id="managerEmail"
                        name="managerEmail"
                        type="email"
                        placeholder="gestor@exemplo.com"
                        required
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    />
                </div>
                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium text-foreground">Descrição</label>
                    <textarea
                        id="description"
                        name="description"
                        placeholder="Adicione detalhes sobre o evento..."
                        rows="3"
                        class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 resize-none"
                    ></textarea>
                </div>
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                    <button type="button" onclick="closeCreateDialog()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        Cancelar
                    </button>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-purple-600 text-white hover:bg-purple-700 h-10 px-4 py-2">
                        Criar Álbum
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let albums = [];

        function openCreateDialog() {
            document.getElementById('create-dialog').classList.remove('hidden');
        }

        function closeCreateDialog() {
            document.getElementById('create-dialog').classList.add('hidden');
        }

        function handleLogout() {
            window.location.href = '{{ route("auth") }}';
        }

        function createAlbum(albumData) {
            const newAlbum = {
                id: Date.now().toString(),
                ...albumData,
                photoCount: 3,
                status: 'draft',
                coverImage: 'https://picsum.photos/800/600?random=' + Date.now()
            };
            
            albums.push(newAlbum);
            localStorage.setItem('albums', JSON.stringify(albums));
            renderAlbums();
            closeCreateDialog();
        }

        function renderAlbums() {
            const emptyState = document.getElementById('empty-state');
            const albumsGrid = document.getElementById('albums-grid');
            
            if (albums.length === 0) {
                emptyState.classList.remove('hidden');
                albumsGrid.classList.add('hidden');
            } else {
                emptyState.classList.add('hidden');
                albumsGrid.classList.remove('hidden');
                
                albumsGrid.innerHTML = albums.map(album => {
                    // Para demonstração, vamos usar uma imagem de placeholder baseada no ID do álbum
                    // Em produção, isto seria substituído por uma chamada à API ou dados do servidor
                    const coverImage = album.coverImage ? `
                        <div class="aspect-video bg-gradient-to-br from-secondary to-muted flex items-center justify-center overflow-hidden">
                            <img src="${album.coverImage}" alt="${album.title}" class="w-full h-full object-cover">
                        </div>
                    ` : `
                        <div class="aspect-video bg-gradient-to-br from-secondary to-muted flex items-center justify-center">
                            <svg class="w-16 h-16 text-muted-foreground/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    `;
                    
                    return `
                        <div class="group hover:shadow-lg transition-all duration-300 cursor-pointer border border-border/50 rounded-lg overflow-hidden bg-card" onclick="navigateToAlbum('${album.id}')">
                            ${coverImage}
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="group-hover:text-primary transition-colors font-semibold">${album.title}</h3>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${album.status === 'published' ? 'bg-primary text-primary-foreground' : 'bg-secondary text-secondary-foreground'}">
                                        ${album.status === 'published' ? 'Publicado' : 'Rascunho'}
                                    </span>
                                </div>
                                <p class="text-sm text-muted-foreground flex items-center gap-2 mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    ${new Date(album.date).toLocaleDateString('pt-PT')}
                                </p>
                                <p class="text-sm text-muted-foreground line-clamp-2 mb-3">${album.description || ''}</p>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-muted-foreground">${album.photoCount} ${album.photoCount === 1 ? 'foto' : 'fotos'}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-muted-foreground truncate">${album.managerEmail}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        function navigateToAlbum(id) {
            window.location.href = `/album/${id}`;
        }

        // Load albums from localStorage on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedAlbums = localStorage.getItem('albums');
            if (savedAlbums) {
                albums = JSON.parse(savedAlbums);
            }
            renderAlbums();

            // Handle form submission
            document.getElementById('create-album-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(e.target);
                const albumData = {
                    title: formData.get('title'),
                    description: formData.get('description'),
                    date: formData.get('date'),
                    managerEmail: formData.get('managerEmail')
                };
                createAlbum(albumData);
            });
        });
    </script>
</x-layouts.app>

