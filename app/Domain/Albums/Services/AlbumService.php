<?php

namespace App\Domain\Albums\Services;

use App\Domain\Albums\Data\AlbumData;
use App\Models\Album;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AlbumService
{
    public function create(AlbumData $data): Album
    {
        return DB::transaction(function () use ($data) {
            return Album::query()->create($data->toArray());
        });
    }

    public function update(Album $album, AlbumData $data): Album
    {
        return DB::transaction(function () use ($album, $data) {
            $album->fill($data->toArray());
            $album->save();

            return $album->fresh();
        });
    }

    public function delete(Album $album): bool
    {
        return DB::transaction(function () use ($album) {
            return $album->delete();
        });
    }

    public function getAll(): LengthAwarePaginator
    {
        return Album::query()->with('photos')->latest()->paginate(15);
    }

    public function find(string $id): ?Album
    {
        return Album::query()->with('photos')->find($id);
    }

    public function updatePin(Album $album, ?string $pin): Album
    {
        return DB::transaction(function () use ($album, $pin) {
            $album->pin = $pin;
            $album->save();

            return $album->fresh();
        });
    }
}
