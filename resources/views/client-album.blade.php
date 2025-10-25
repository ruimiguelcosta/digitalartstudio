<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background">
        <header class="border-b border-border/50 bg-card/50 backdrop-blur-sm sticky top-0 z-10">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 id="album-title" class="text-xl font-bold">Carregando...</h1>
                            <p id="album-date" class="text-sm text-muted-foreground flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Carregando...
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="checkout-btn" onclick="openCheckout()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 gap-2 hidden">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span id="checkout-text">Comprar (0)</span>
                        </button>
                        <button onclick="handleLogout()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sair
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Sem fotos disponíveis</h3>
                    <p class="text-muted-foreground text-center">
                        O fotógrafo ainda não adicionou fotos a este álbum.
                    </p>
                </div>
            </div>

            <!-- Photos Grid -->
            <div id="photos-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden">
                <!-- Photos will be dynamically added here -->
            </div>
        </main>
    </div>

    <!-- Checkout Dialog -->
    <div id="checkout-dialog" class="fixed inset-0 z-50 bg-black/80 hidden">
        <div class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left">
                <h2 class="text-lg font-semibold leading-none tracking-tight">Finalizar Compra</h2>
                <p id="checkout-description" class="text-sm text-muted-foreground">
                    0 fotos selecionadas
                </p>
            </div>
            <div class="space-y-6 py-4">
                <div class="space-y-4">
                    <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Escolha o tipo de entrega</label>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 border border-border/50 rounded-lg p-4 hover:border-primary/50 transition-colors">
                            <input type="radio" id="digital" name="priceOption" value="digital" checked class="h-4 w-4 border-gray-300 text-primary focus:ring-primary">
                            <label for="digital" class="flex-1 cursor-pointer">
                                <div class="font-medium">Digital</div>
                                <div class="text-sm text-muted-foreground">Download em alta resolução</div>
                            </label>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">€5/foto</span>
                        </div>
                        <div class="flex items-center space-x-3 border border-border/50 rounded-lg p-4 hover:border-primary/50 transition-colors">
                            <input type="radio" id="digital_print" name="priceOption" value="digital_print" class="h-4 w-4 border-gray-300 text-primary focus:ring-primary">
                            <label for="digital_print" class="flex-1 cursor-pointer">
                                <div class="font-medium">Digital + Impressão</div>
                                <div class="text-sm text-muted-foreground">Download + envio de impressão física</div>
                            </label>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-secondary text-secondary-foreground">€15/foto</span>
                        </div>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total:</span>
                        <span id="total-price">€0</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <button type="button" onclick="closeCheckout()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                    Cancelar
                </button>
                <button onclick="confirmPurchase()" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                    Confirmar Compra
                </button>
            </div>
        </div>
    </div>

    <script>
        let album = null;
        let photos = [];
        let selectedPhotos = new Set();
        const albumId = '{{ $id }}';
        const PRICES = {
            digital: 5,
            digital_print: 15
        };

        function handleLogout() {
            localStorage.removeItem('client_session');
            window.location.href = '{{ route("client.auth") }}';
        }

        function togglePhotoSelection(photoId) {
            if (selectedPhotos.has(photoId)) {
                selectedPhotos.delete(photoId);
            } else {
                selectedPhotos.add(photoId);
            }
            updateCheckoutButton();
            renderPhotos();
        }

        function updateCheckoutButton() {
            const checkoutBtn = document.getElementById('checkout-btn');
            const checkoutText = document.getElementById('checkout-text');
            
            if (selectedPhotos.size > 0) {
                checkoutBtn.classList.remove('hidden');
                checkoutText.textContent = `Comprar (${selectedPhotos.size})`;
            } else {
                checkoutBtn.classList.add('hidden');
            }
        }

        function openCheckout() {
            if (selectedPhotos.size === 0) {
                alert('Nenhuma foto selecionada. Selecione pelo menos uma foto para comprar.');
                return;
            }
            
            document.getElementById('checkout-description').textContent = 
                `${selectedPhotos.size} ${selectedPhotos.size === 1 ? 'foto selecionada' : 'fotos selecionadas'}`;
            updateTotalPrice();
            document.getElementById('checkout-dialog').classList.remove('hidden');
        }

        function closeCheckout() {
            document.getElementById('checkout-dialog').classList.add('hidden');
        }

        function updateTotalPrice() {
            const priceOption = document.querySelector('input[name="priceOption"]:checked').value;
            const total = selectedPhotos.size * PRICES[priceOption];
            document.getElementById('total-price').textContent = `€${total}`;
        }

        function confirmPurchase() {
            const priceOption = document.querySelector('input[name="priceOption"]:checked').value;
            const total = selectedPhotos.size * PRICES[priceOption];
            
            alert(`Compra realizada! ${selectedPhotos.size} ${selectedPhotos.size === 1 ? 'foto' : 'fotos'} - Total: €${total}`);
            
            selectedPhotos.clear();
            updateCheckoutButton();
            renderPhotos();
            closeCheckout();
        }

        function loadAlbum() {
            const session = localStorage.getItem('client_session');
            if (!session) {
                window.location.href = `{{ route('client.auth') }}?album=${albumId}`;
                return;
            }

            const { email } = JSON.parse(session);

            const savedAlbums = localStorage.getItem('albums');
            if (savedAlbums) {
                const albums = JSON.parse(savedAlbums);
                album = albums.find(
                    a => a.id === albumId && a.managerEmail === email && a.status === 'published'
                );
                
                if (album) {
                    document.getElementById('album-title').textContent = album.title;
                    document.getElementById('album-date').innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        ${new Date(album.date).toLocaleDateString('pt-PT')}
                    `;
                    
                    if (album.description) {
                        document.getElementById('description-text').textContent = album.description;
                        document.getElementById('album-description').classList.remove('hidden');
                    }
                } else {
                    alert('Álbum não encontrado. Não tem acesso a este álbum.');
                    window.location.href = '{{ route("client.auth") }}';
                    return;
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
                
                photosGrid.innerHTML = photos.map(photo => {
                    const isSelected = selectedPhotos.has(photo.id);
                    return `
                        <div class="group overflow-hidden border-2 cursor-pointer transition-all duration-300 rounded-lg bg-card ${
                            isSelected
                                ? 'border-primary shadow-lg scale-[0.98]'
                                : 'border-border/50 hover:border-primary/50 hover:shadow-md'
                        }" onclick="togglePhotoSelection('${photo.id}')">
                            <div class="aspect-square relative">
                                <img
                                    src="${photo.dataUrl}"
                                    alt="Event photo"
                                    class="w-full h-full object-cover"
                                />
                                ${isSelected ? `
                                    <div class="absolute inset-0 bg-primary/20 flex items-center justify-center">
                                        <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }).join('');
            }
        }

        // Add event listeners for price option changes
        document.addEventListener('change', function(e) {
            if (e.target.name === 'priceOption') {
                updateTotalPrice();
            }
        });

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadAlbum();
            loadPhotos();
        });
    </script>
</x-layouts.app>


