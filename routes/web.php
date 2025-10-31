<?php

use App\Actions\Http\Auth\LoginAction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/album/{id}', function (string $id) {
    return view('albums.show', ['id' => $id]);
})->name('albums.show');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', LoginAction::class)->middleware('guest')->name('login.post');

Route::get('/dashboard', function () {
    $albumId = session('album_access');
    if (! $albumId) {
        return redirect()->route('login')->with('error', 'Por favor, faça login para acessar o álbum.');
    }

    return view('dashboard');
})->name('dashboard');

Route::post('/logout', function () {
    session()->forget('album_access');

    return redirect()->route('index');
})->name('logout');

Route::fallback(function () {
    return view('not-found');
});

Route::get('/storage/photos/{path}', function (string $path) {
    $decodedPath = base64_decode($path);

    if (! Storage::disk('local')->exists($decodedPath)) {
        abort(404);
    }

    return Storage::disk('local')->response($decodedPath);
})->where('path', '.*')->middleware(['web', \Filament\Http\Middleware\Authenticate::class])->name('filament.admin.storage.photo');

Route::get('/album-photo/{path}', function (string $path) {
    $session = request()->session();
    $albumId = $session->get('album_access');

    if (! $albumId) {
        abort(403, 'Acesso negado. Faça login para visualizar as fotos.');
    }

    $decodedPath = base64_decode($path, true);
    if ($decodedPath === false) {
        abort(404, 'Caminho inválido.');
    }

    $photo = \App\Models\Photo::query()
        ->where('path', $decodedPath)
        ->where('album_id', $albumId)
        ->first();

    if (! $photo) {
        abort(404, 'Foto não encontrada neste álbum.');
    }

    if (! Storage::disk('local')->exists($decodedPath)) {
        abort(404, 'Arquivo não encontrado.');
    }

    $response = Storage::disk('local')->response($decodedPath);

    $response->headers->set('Cache-Control', 'private, max-age=3600');
    $response->headers->set('X-Content-Type-Options', 'nosniff');

    return $response;
})->where('path', '.*')->middleware(['web', 'signed'])->name('album.photo');
