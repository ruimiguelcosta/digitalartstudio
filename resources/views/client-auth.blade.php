<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-background via-secondary/20 to-background flex items-center justify-center p-4">
        <div class="border border-border/50 rounded-lg shadow-xl backdrop-blur bg-card w-full max-w-md">
            <div class="p-6 space-y-4 text-center">
                <div class="flex justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold">Acesso ao Álbum</h1>
                    <p class="text-muted-foreground mt-2">
                        Introduza o seu email para aceder às fotos do evento
                    </p>
                </div>
            </div>
            <div class="p-6 pt-0">
                <form id="client-login-form" class="space-y-4">
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                        <input
                            id="email"
                            type="email"
                            placeholder="seu@email.com"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        />
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                        Aceder ao Álbum
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('client-login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            
            // Find albums where this email is the manager
            const savedAlbums = localStorage.getItem('albums');
            if (savedAlbums) {
                const albums = JSON.parse(savedAlbums);
                const clientAlbums = albums.filter(
                    album => album.managerEmail === email && album.status === 'published'
                );

                if (clientAlbums.length > 0) {
                    localStorage.setItem('client_session', JSON.stringify({ email }));
                    
                    // Redirect to first album or specified album
                    const urlParams = new URLSearchParams(window.location.search);
                    const albumId = urlParams.get('album') || clientAlbums[0].id;
                    window.location.href = `/client-album/${albumId}`;
                } else {
                    alert('Acesso negado: Não foram encontrados álbuns para este email.');
                }
            } else {
                alert('Acesso negado: Não foram encontrados álbuns para este email.');
            }
        });
    </script>
</x-layouts.app>

