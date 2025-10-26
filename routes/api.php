<?php

use App\Actions\Http\Albums\{
    IndexAlbumAction,
    StoreAlbumAction,
    ShowAlbumAction,
    UpdateAlbumAction,
    DestroyAlbumAction
};

use App\Actions\Http\Photos\{
    IndexPhotoAction,
    StorePhotoAction,
    ShowPhotoAction,
    UpdatePhotoAction,
    DestroyPhotoAction
};

use Illuminate\Support\Facades\Route;

Route::prefix('albums')->group(function () {
    Route::get('/', IndexAlbumAction::class);
    Route::post('/', StoreAlbumAction::class);
    Route::get('{album}', ShowAlbumAction::class);
    Route::patch('{album}', UpdateAlbumAction::class);
    Route::delete('{album}', DestroyAlbumAction::class);
});

Route::prefix('photos')->group(function () {
    Route::get('/', IndexPhotoAction::class);
    Route::post('/', StorePhotoAction::class);
    Route::get('{photo}', ShowPhotoAction::class);
    Route::patch('{photo}', UpdatePhotoAction::class);
    Route::delete('{photo}', DestroyPhotoAction::class);
});
