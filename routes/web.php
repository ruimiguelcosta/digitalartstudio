<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/storage/photos/{path}', function (string $path) {
    $decodedPath = base64_decode($path);

    if (! Storage::disk('local')->exists($decodedPath)) {
        abort(404);
    }

    return Storage::disk('local')->response($decodedPath);
})->where('path', '.*')->middleware(['web', \Filament\Http\Middleware\Authenticate::class])->name('filament.admin.storage.photo');
