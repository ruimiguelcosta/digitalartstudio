<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl logo-gradient mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-foreground">PhotoEvents</h1>
                <p class="text-muted-foreground mt-2">Plataforma de vendas de fotos de eventos</p>
            </div>

            <div class="card-elevated rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold">Área do Fotógrafo</h2>
                        <p class="text-muted-foreground">Entre ou crie uma conta para continuar</p>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Tabs -->
                        <div class="grid w-full grid-cols-2 rounded-lg bg-muted p-1">
                            <button id="login-tab" class="tab-active rounded-md px-3 py-2 text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                                Entrar
                            </button>
                            <button id="signup-tab" class="tab-inactive rounded-md px-3 py-2 text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring hover:text-foreground">
                                Registar
                            </button>
                        </div>
                        
                        <!-- Login Form -->
                        <div id="login-content" class="space-y-4">
                            <form class="space-y-4">
                                <div class="space-y-2">
                                    <label for="login-email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                                    <input
                                        id="login-email"
                                        name="email"
                                        type="email"
                                        placeholder="seu@email.com"
                                        required
                                        class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label for="login-password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label>
                                    <input
                                        id="login-password"
                                        name="password"
                                        type="password"
                                        placeholder="••••••••"
                                        required
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    />
                                </div>
                                <button type="submit" class="btn-primary inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2 w-full">
                                    Entrar
                                </button>
                            </form>
                        </div>
                        
                        <!-- Signup Form -->
                        <div id="signup-content" class="space-y-4 hidden">
                            <form class="space-y-4">
                                <div class="space-y-2">
                                    <label for="signup-name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Nome</label>
                                    <input
                                        id="signup-name"
                                        name="name"
                                        type="text"
                                        placeholder="Seu nome"
                                        required
                                        class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label for="signup-email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                                    <input
                                        id="signup-email"
                                        name="email"
                                        type="email"
                                        placeholder="seu@email.com"
                                        required
                                        class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label for="signup-password" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Password</label>
                                    <input
                                        id="signup-password"
                                        name="password"
                                        type="password"
                                        placeholder="••••••••"
                                        required
                                        class="input-focus flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    />
                                </div>
                                <button type="submit" class="btn-primary inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2 w-full">
                                    Criar Conta
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const loginTab = document.getElementById('login-tab');
            const signupTab = document.getElementById('signup-tab');
            const loginContent = document.getElementById('login-content');
            const signupContent = document.getElementById('signup-content');

            loginTab.addEventListener('click', function() {
                loginTab.classList.remove('tab-inactive');
                loginTab.classList.add('tab-active');
                signupTab.classList.remove('tab-active');
                signupTab.classList.add('tab-inactive');
                
                loginContent.classList.remove('hidden');
                signupContent.classList.add('hidden');
            });

            signupTab.addEventListener('click', function() {
                signupTab.classList.remove('tab-inactive');
                signupTab.classList.add('tab-active');
                loginTab.classList.remove('tab-active');
                loginTab.classList.add('tab-inactive');
                
                signupContent.classList.remove('hidden');
                loginContent.classList.add('hidden');
            });

            // Form submissions
            document.querySelector('#login-content form').addEventListener('submit', function(e) {
                e.preventDefault();
                // Simulate login
                setTimeout(() => {
                    window.location.href = '{{ route("dashboard") }}';
                }, 800);
            });

            document.querySelector('#signup-content form').addEventListener('submit', function(e) {
                e.preventDefault();
                // Simulate signup
                setTimeout(() => {
                    window.location.href = '{{ route("dashboard") }}';
                }, 800);
            });
        });
    </script>
</x-layouts.app>

