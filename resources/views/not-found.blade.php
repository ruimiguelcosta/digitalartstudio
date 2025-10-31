@extends('layouts.app')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-background">
    <div class="text-center">
        <h1 class="mb-4 text-4xl font-bold">404</h1>
        <p class="mb-4 text-xl text-muted-foreground">Oops! Página não encontrada</p>
        <a href="{{ route('index') }}" class="text-primary underline hover:text-primary/90">
            Voltar ao Início
        </a>
    </div>
</div>
@endsection

