<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/album/{id}', function (string $id) {
    return view('albums.show', ['id' => $id]);
})->name('albums.show');

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
