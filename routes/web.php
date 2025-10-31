<?php

use App\Actions\Http\Albums\LoginAlbumGuestAction;
use App\Actions\Http\Albums\ShowAlbumGuestAction;
use App\Actions\Http\Auth\LoginAction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/album/{id}', function (string $id) {
    return view('albums.show', ['id' => $id]);
})->name('albums.show');

Route::get('/shop', function () {
    if (session('shop_user_email')) {
        return redirect()->route('shop.dashboard');
    }

    return view('shop');
})->name('shop');

Route::post('/shop/login', \App\Actions\Http\Shop\ShopLoginAction::class)->name('shop.login');

Route::get('/shop/dashboard', function () {
    if (! session('shop_user_email')) {
        return redirect()->route('shop')->with('error', 'Por favor, faça login para acessar o dashboard.');
    }

    $albumId = session('shop_album_id');
    $album = \App\Models\Album::query()->with('photos')->find($albumId);

    if (! $album) {
        return redirect()->route('shop')->with('error', 'Álbum não encontrado.');
    }

    return view('shop.dashboard', ['album' => $album]);
})->name('shop.dashboard');

Route::get('/shop/album/{album}', function (string $album) {
    if (! session('shop_user_email')) {
        return redirect()->route('shop')->with('error', 'Por favor, faça login para acessar o álbum.');
    }

    $albumId = session('shop_album_id');
    if ($albumId !== $album) {
        return redirect()->route('shop.dashboard')->with('error', 'Acesso negado a este álbum.');
    }

    $albumModel = \App\Models\Album::query()->findOrFail($album);
    $photos = $albumModel->photos()->paginate(150);
    $cart = session('shop_cart', []);
    $services = \App\Models\Service::query()->orderBy('price')->get();

    return view('shop.album', [
        'album' => $albumModel,
        'photos' => $photos,
        'cart' => $cart,
        'services' => $services,
    ]);
})->name('shop.album');

Route::post('/shop/cart/add', \App\Actions\Http\Shop\AddToCartAction::class)->name('shop.cart.add');
Route::post('/shop/cart/remove', \App\Actions\Http\Shop\RemoveFromCartAction::class)->name('shop.cart.remove');

Route::get('/shop/checkout', function () {
    if (! session('shop_user_email')) {
        return redirect()->route('shop')->with('error', 'Por favor, faça login para finalizar a compra.');
    }

    $cart = session('shop_cart', []);
    if (empty($cart)) {
        return redirect()->route('shop.dashboard')->with('error', 'O seu carrinho está vazio.');
    }

    $albumId = session('shop_album_id');
    $album = \App\Models\Album::query()->find($albumId);
    $userEmail = session('shop_user_email');
    $services = \App\Models\Service::query()->orderBy('price')->get();

    return view('shop.checkout', [
        'cart' => $cart,
        'album' => $album,
        'userEmail' => $userEmail,
        'services' => $services,
    ]);
})->name('shop.checkout');

Route::post('/shop/cart/update-service', \App\Actions\Http\Shop\UpdateCartServiceAction::class)->name('shop.cart.update-service');

Route::post('/shop/checkout', \App\Actions\Http\Shop\ProcessCheckoutAction::class)->name('shop.checkout.process');

Route::post('/shop/logout', function () {
    session()->forget('shop_user_email');
    session()->forget('shop_album_id');
    session()->forget('shop_cart');

    return redirect()->route('shop')->with('success', 'Sessão terminada com sucesso.');
})->name('shop.logout');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', LoginAction::class)->middleware('guest')->name('login.post');

Route::get('/shop/albums/{album}', ShowAlbumGuestAction::class)->name('albums.guest.show');
Route::post('/shop/albums/{album}', LoginAlbumGuestAction::class)->name('albums.guest.login');

Route::get('/dashboard', function () {
    $albumId = session('album_access');
    if (! $albumId) {
        return redirect()->route('shop')->with('error', 'Por favor, faça login para acessar o álbum.');
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
    $decodedPath = base64_decode($path, true);
    if ($decodedPath === false) {
        abort(404, 'Caminho inválido.');
    }

    $photo = \App\Models\Photo::query()
        ->where('path', $decodedPath)
        ->first();

    if (! $photo) {
        abort(404, 'Foto não encontrada.');
    }

    $session = request()->session();
    $albumId = $session->get('album_access');

    if (! $albumId) {
        $albumId = $session->get("album_guest_access_{$photo->album_id}");
    }

    if (! $albumId) {
        $shopAlbumId = $session->get('shop_album_id');
        if ($shopAlbumId === $photo->album_id) {
            $albumId = $shopAlbumId;
        }
    }

    if ($albumId !== $photo->album_id) {
        abort(403, 'Acesso negado. Faça login para visualizar as fotos.');
    }

    if (! Storage::disk('local')->exists($decodedPath)) {
        abort(404, 'Arquivo não encontrado.');
    }

    $response = Storage::disk('local')->response($decodedPath);

    $response->headers->set('Cache-Control', 'private, max-age=3600');
    $response->headers->set('X-Content-Type-Options', 'nosniff');

    return $response;
})->where('path', '.*')->middleware(['web', 'signed'])->name('album.photo');
