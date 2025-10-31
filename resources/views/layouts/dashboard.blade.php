<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Álbum Privado - António Braga' }}</title>
    <meta name="description" content="Visualize o seu álbum privado de fotografias" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-background">
    <nav class="border-b border-border bg-secondary py-4 px-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('index') }}" class="font-serif text-xl font-bold text-foreground">
                António Braga
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground px-4 py-2"
                >
                    Sair
                </button>
            </form>
        </div>
    </nav>
    @yield('content')
</body>
</html>

