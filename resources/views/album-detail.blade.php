<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background">
        <header class="border-b border-border/50 bg-card/50 backdrop-blur-sm sticky top-0 z-10">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center gap-4">
                    <button onclick="goBack()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h1 id="album-title" class="text-xl font-bold">Carregando...</h1>
                                <span id="album-status" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">
                                    Rascunho
                                </span>
                            </div>
                            <p id="album-info" class="text-sm text-muted-foreground">
                                Carregando...
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <input
                            id="file-input"
                            type="file"
                            multiple
                            accept="image/*"
                            class="hidden"
                        />
                        <button id="publish-btn" onclick="publishAlbum()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 gap-2 hidden">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Publicar
                        </button>
                        <button onclick="uploadPhotos()" id="upload-btn" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload Fotos
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="container mx-auto px-4 py-8">
            <!-- Album Description -->
            <div id="album-description" class="border border-border/50 rounded-lg mb-8 bg-card hidden">
                <div class="p-6">
                    <p id="description-text" class="text-muted-foreground"></p>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="border border-dashed rounded-lg">
                <div class="flex flex-col items-center justify-center py-16 px-6">
                    <svg class="w-16 h-16 text-muted-foreground/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Nenhuma foto no álbum</h3>
                    <p class="text-muted-foreground text-center mb-6 max-w-md">
                        Faça upload das fotos do evento para começar
                    </p>
                    <button onclick="uploadPhotos()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Upload Fotos
                    </button>
                </div>
            </div>

            <!-- Photos Grid -->
            <div id="photos-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden">
                <!-- Photos will be dynamically added here -->
            </div>
        </main>
    </div>

    <script>
        let album = null;
        let photos = [];
        const albumId = '{{ $id }}';

        function goBack() {
            window.location.href = '{{ route("dashboard") }}';
        }

        function uploadPhotos() {
            document.getElementById('file-input').click();
        }

        function publishAlbum() {
            if (!album) return;
            
            album.status = 'published';
            
            const savedAlbums = localStorage.getItem('albums');
            if (savedAlbums) {
                const albums = JSON.parse(savedAlbums);
                const updatedAlbums = albums.map(a => a.id === albumId ? album : a);
                localStorage.setItem('albums', JSON.stringify(updatedAlbums));
            }
            
            loadAlbum();
        }

        function deletePhoto(photoId) {
            photos = photos.filter(p => p.id !== photoId);
            localStorage.setItem(`photos_${albumId}`, JSON.stringify(photos));
            
            if (album) {
                album.photoCount = photos.length;
                const savedAlbums = localStorage.getItem('albums');
                if (savedAlbums) {
                    const albums = JSON.parse(savedAlbums);
                    const updatedAlbums = albums.map(a => a.id === albumId ? album : a);
                    localStorage.setItem('albums', JSON.stringify(updatedAlbums));
                }
            }
            
            renderPhotos();
        }

        function loadAlbum() {
            const savedAlbums = localStorage.getItem('albums');
            if (savedAlbums) {
                const albums = JSON.parse(savedAlbums);
                album = albums.find(a => a.id === albumId);
                
                if (album) {
                    document.getElementById('album-title').textContent = album.title;
                    document.getElementById('album-info').textContent = 
                        `${new Date(album.date).toLocaleDateString('pt-PT')} • ${photos.length} ${photos.length === 1 ? 'foto' : 'fotos'}`;
                    
                    const statusElement = document.getElementById('album-status');
                    if (album.status === 'published') {
                        statusElement.textContent = 'Publicado';
                        statusElement.className = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-primary text-primary-foreground';
                        document.getElementById('publish-btn').classList.add('hidden');
                    } else {
                        statusElement.textContent = 'Rascunho';
                        statusElement.className = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground';
                        document.getElementById('publish-btn').classList.remove('hidden');
                    }
                    
                    if (album.description) {
                        document.getElementById('description-text').textContent = album.description;
                        document.getElementById('album-description').classList.remove('hidden');
                    }
                }
            }
        }

        function loadPhotos() {
            const savedPhotos = localStorage.getItem(`photos_${albumId}`);
            if (savedPhotos) {
                photos = JSON.parse(savedPhotos);
            }
            renderPhotos();
        }

        function renderPhotos() {
            const emptyState = document.getElementById('empty-state');
            const photosGrid = document.getElementById('photos-grid');
            
            if (photos.length === 0) {
                emptyState.classList.remove('hidden');
                photosGrid.classList.add('hidden');
            } else {
                emptyState.classList.add('hidden');
                photosGrid.classList.remove('hidden');
                
                photosGrid.innerHTML = photos.map(photo => `
                    <div class="group overflow-hidden border border-border/50 rounded-lg hover:shadow-lg transition-all duration-300 bg-card">
                        <div class="aspect-square relative">
                            <img
                                src="${photo.dataUrl}"
                                alt="Event photo"
                                class="w-full h-full object-cover"
                            />
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button
                                    onclick="deletePhoto('${photo.id}')"
                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 w-10"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
        }

        // Handle file upload
        document.getElementById('file-input').addEventListener('change', function(e) {
            const files = e.target.files;
            if (!files) return;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(event) {
                    const photo = {
                        id: `${Date.now()}_${i}`,
                        albumId: albumId,
                        dataUrl: event.target.result,
                        uploadedAt: new Date().toISOString()
                    };
                    
                    photos.push(photo);
                    localStorage.setItem(`photos_${albumId}`, JSON.stringify(photos));
                    
                    if (album) {
                        album.photoCount = photos.length;
                        if (photos.length === 1) {
                            album.coverImage = photo.dataUrl;
                        }
                        
                        const savedAlbums = localStorage.getItem('albums');
                        if (savedAlbums) {
                            const albums = JSON.parse(savedAlbums);
                            const updatedAlbums = albums.map(a => a.id === albumId ? album : a);
                            localStorage.setItem('albums', JSON.stringify(updatedAlbums));
                        }
                    }
                    
                    renderPhotos();
                    loadAlbum();
                };
                
                reader.readAsDataURL(file);
            }
            
            // Reset file input
            e.target.value = '';
        });

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadPhotos();
            loadAlbum();
        });
    </script>
</x-layouts.app>

