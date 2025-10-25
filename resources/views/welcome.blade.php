<x-layouts.app>
    <div class="min-h-screen bg-gradient-subtle">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <!-- Logo Principal -->
                    <div class="flex justify-center mb-8">
                        <div class="logo-container">
                            <img src="{{ asset('images/logo.jpeg') }}" 
                                 alt="Digital Art Studio" 
                                 class="h-28 w-auto object-contain">
                        </div>
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-6">
                        <span class="accent-logo">Digital Art Studio</span>
                    </h1>
                    
                    <p class="text-xl text-muted-foreground mb-8 max-w-3xl mx-auto">
                        Transforme suas memórias em arte digital. Crie álbuns personalizados, 
                        organize suas fotos e compartilhe momentos especiais com quem você ama.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="/dashboard" class="btn-logo inline-flex items-center justify-center px-8 py-3 text-lg font-medium rounded-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Ir para Dashboard
                            </a>
                        @else
                            <a href="/auth" class="btn-logo inline-flex items-center justify-center px-8 py-3 text-lg font-medium rounded-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Fazer Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 bg-card/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold tracking-tight mb-4">
                        <span class="accent-logo">Recursos</span>
                    </h2>
                    <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                        Descubra todas as funcionalidades que tornam o Digital Art Studio 
                        a escolha perfeita para organizar suas memórias.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="card-elevated rounded-lg p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl logo-gradient mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Álbuns Personalizados</h3>
                        <p class="text-muted-foreground">
                            Crie álbuns temáticos para organizar suas fotos por eventos, 
                            datas ou qualquer critério que desejar.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="card-elevated rounded-lg p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl logo-gradient mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Privacidade Total</h3>
                        <p class="text-muted-foreground">
                            Controle quem pode acessar seus álbuns com configurações 
                            de privacidade avançadas e links seguros.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="card-elevated rounded-lg p-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl logo-gradient mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Performance Rápida</h3>
                        <p class="text-muted-foreground">
                            Upload e visualização otimizados para uma experiência 
                            fluida, mesmo com milhares de fotos.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="py-20">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold tracking-tight mb-6">
                    <span class="accent-logo">Pronto para começar?</span>
                </h2>
                <p class="text-lg text-muted-foreground mb-8">
                    Junte-se a milhares de usuários que já transformaram suas memórias 
                    em arte digital com o Digital Art Studio.
                </p>
                <a href="/auth" class="btn-logo inline-flex items-center justify-center px-8 py-3 text-lg font-medium rounded-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Começar Agora
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
