<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Digital Art Studio') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-subtle min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Header -->
        <nav class="bg-card/80 backdrop-blur-md border-b border-border sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="logo-container">
                            <img src="{{ asset('images/logo.jpeg') }}"
                                 alt="Digital Art Studio"
                                 class="h-11 w-auto object-contain">
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-6">
                        @auth
                            <a href="/dashboard" class="text-foreground hover:text-primary transition-colors duration-200 font-medium">
                                Dashboard
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="/services" class="text-foreground hover:text-primary transition-colors duration-200 font-medium">
                                    Serviços
                                </a>
                            @endif
                        @else
                            <a href="/auth" class="text-foreground hover:text-primary transition-colors duration-200 font-medium">
                                Login
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-foreground hover:text-primary transition-colors duration-200">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-card/50 backdrop-blur-sm border-t border-border mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-3 mb-4 md:mb-0">
                        <div class="logo-container">
                            <img src="{{ asset('images/logo.jpeg') }}"
                                 alt="Digital Art Studio"
                                 class="h-8 w-auto object-contain">
                        </div>
                        <span class="text-sm font-medium text-muted-foreground">
                            © {{ date('Y') }} Digital Art Studio. Todos os direitos reservados.
                        </span>
                    </div>
                    <div class="flex space-x-6">
                        @auth
                            <a href="/dashboard" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-200">
                                Dashboard
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="/services" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-200">
                                    Serviços
                                </a>
                            @endif
                        @else
                            <a href="/auth" class="text-sm text-muted-foreground hover:text-primary transition-colors duration-200">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
