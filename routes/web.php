<?php

use App\Actions\Http\AlbumDetailAction;
use App\Actions\Http\Albums\DeleteAlbumAction;
use App\Actions\Http\Albums\IndexAlbumsAction;
use App\Actions\Http\Albums\ShowAlbumAction;
use App\Actions\Http\Albums\StoreAlbumAction;
use App\Actions\Http\Albums\UpdateAlbumAction;
use App\Actions\Http\Auth\LoginAction;
use App\Actions\Http\Auth\LogoutAction;
use App\Actions\Http\AuthAction;
use App\Actions\Http\ClientAlbumAction;
use App\Actions\Http\ClientAuthAction;
use App\Actions\Http\DashboardAction;
use App\Actions\Http\IndexAction;
use App\Actions\Http\Photos\DeletePhotoAction;
use App\Actions\Http\Photos\StoreMultiplePhotosAction;
use App\Actions\Http\Photos\StorePhotoAction;
use App\Actions\Http\Photos\UpdatePhotoAction;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexAction::class)->name('index');
Route::get('/auth', AuthAction::class)->name('auth');
Route::get('/client-auth', ClientAuthAction::class)->name('client.auth');
Route::get('/client-album/{id}', ClientAlbumAction::class)->name('client.album');

Route::post('/api/auth/login', LoginAction::class)->name('auth.login');
Route::post('/api/auth/logout', LogoutAction::class)->name('auth.logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', DashboardAction::class)->name('dashboard');
    Route::get('/album/{id}', AlbumDetailAction::class)->name('album.detail')->middleware('track.album.access');

    Route::prefix('api/albums')->group(function () {
        Route::get('/', IndexAlbumsAction::class);
        Route::post('/', StoreAlbumAction::class);
        Route::get('/{album}', ShowAlbumAction::class);
        Route::get('/{album}/photos', function ($album) {
            $photos = \App\Models\Photo::query()->where('album_id', $album)->orderBy('order')->get();

            return response()->json($photos);
        });
        Route::patch('/{album}', UpdateAlbumAction::class);
        Route::delete('/{album}', DeleteAlbumAction::class);
    });

    Route::prefix('api/photos')->group(function () {
        Route::post('/', StorePhotoAction::class);
        Route::post('/multiple', StoreMultiplePhotosAction::class)->name('photos.store');
        Route::patch('/{photo}', UpdatePhotoAction::class);
        Route::delete('/{photo}', DeletePhotoAction::class);
    });

    Route::delete('/photos/{photo}', DeletePhotoAction::class);
});
