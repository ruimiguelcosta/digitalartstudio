<?php

namespace App\Observers;

use App\AlbumStatus;
use App\Jobs\SendAlbumManagerEmailJob;
use App\Models\Album;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

class AlbumObserver
{
    public function creating(Album $album): void
    {
        if (empty($album->slug)) {
            $album->slug = $this->generateSlug($album->name);
        }

        if (empty($album->pin)) {
            $album->pin = $this->generatePin();
        }
    }

    public function updating(Album $album): void
    {
        $originalPin = $album->getOriginal('pin');

        if (empty($originalPin)) {
            $album->pin = $this->generatePin();
        }
    }

    public function updated(Album $album): void
    {
        if ($album->wasChanged('status') && $album->status === AlbumStatus::Private && ! empty($album->manager_email)) {
            $this->createManagerAndSendEmail($album);
        }
    }

    public function created(Album $album): void
    {
        if ($album->status === AlbumStatus::Private && ! empty($album->manager_email)) {
            $this->createManagerAndSendEmail($album);
        }
    }

    private function createManagerAndSendEmail(Album $album): void
    {
        $user = User::query()->where('email', $album->manager_email)->first();

        if (! $user) {
            $password = Str::password(12);
            $loginUrl = 'https://www.digitalartstudio.pt/admin';

            $user = new User;
            $user->name = "manager do album {$album->name}";
            $user->email = $album->manager_email;
            $user->password = $password;
            $user->email_verified_at = now();
            $user->save();

            $managerRole = Role::query()->where('slug', 'manager')->first();
            if ($managerRole) {
                $user->roles()->attach($managerRole);
            }

            SendAlbumManagerEmailJob::dispatch(
                $album->manager_email,
                $album->name,
                $password,
                $loginUrl
            );
        }

        $album->manager_id = $user->id;
        $album->saveQuietly();
    }

    private function generateSlug(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';

        foreach ($words as $word) {
            if (! empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        $slug = strtoupper(substr($initials, 0, 3));

        $counter = 1;
        $uniqueSlug = $slug.str_pad((string) $counter, 4, '0', STR_PAD_LEFT);

        while (Album::query()->where('slug', $uniqueSlug)->exists()) {
            $counter++;
            $uniqueSlug = $slug.str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
        }

        return $uniqueSlug;
    }

    private function generatePin(): string
    {
        return Str::random(12);
    }

    public function deleted(Album $album): void
    {
        //
    }

    public function restored(Album $album): void
    {
        //
    }

    public function forceDeleted(Album $album): void
    {
        //
    }
}
