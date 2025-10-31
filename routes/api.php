<?php

use App\Actions\Http\Albums\DestroyAlbumAction;
use App\Actions\Http\Albums\IndexAlbumAction;
use App\Actions\Http\Albums\ShowAlbumAction;
use App\Actions\Http\Albums\StoreAlbumAction;
use App\Actions\Http\Albums\UpdateAlbumAction;
use App\Actions\Http\Albums\UpdateAlbumPinAction;
use App\Actions\Http\Photos\DestroyPhotoAction;
use App\Actions\Http\Photos\IndexPhotoAction;
use App\Actions\Http\Photos\ShowPhotoAction;
use App\Actions\Http\Photos\StorePhotoAction;
use App\Actions\Http\Photos\UpdatePhotoAction;
use Illuminate\Support\Facades\Route;

Route::prefix('albums')->group(function () {
    Route::get('/', IndexAlbumAction::class);
    Route::post('/', StoreAlbumAction::class);
    Route::patch('{album}/pin', UpdateAlbumPinAction::class);
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
