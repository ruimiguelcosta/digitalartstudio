<?php

namespace App\Http\Middleware;

use App\Models\AlbumAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackAlbumAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests to album detail pages
        if ($request->isMethod('GET') && $request->route('album')) {
            $album = $request->route('album');

            // Only track if album is public or user is authenticated
            if ($album->is_public || Auth::check()) {
                AlbumAccess::create([
                    'album_id' => $album->id,
                    'user_id' => Auth::id(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'accessed_at' => now(),
                ]);
            }
        }

        return $response;
    }
}
