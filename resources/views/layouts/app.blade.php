<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'António Braga - Fotografia Profissional | 30+ Anos de Experiência' }}</title>
    <meta name="description" content="{{ $description ?? 'Fotógrafo profissional com mais de 30 anos de experiência em casamentos, festas, peças musicais, teatro e dança. Capture seus momentos especiais com António Braga.' }}" />
    <meta name="author" content="António Braga" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <meta property="og:title" content="António Braga - Fotografia Profissional" />
    <meta property="og:description" content="Fotógrafo profissional com mais de 30 anos de experiência em casamentos, festas, peças musicais, teatro e dança." />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-background">
    @yield('content')
</body>
</html>

