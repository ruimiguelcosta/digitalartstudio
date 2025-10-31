<?php

namespace App\Observers;

use App\AlbumStatus;
use App\Jobs\SendAlbumManagerEmailJob;
use App\Models\Album;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AlbumObserver
{
    public function creating(Album $album): void
    {
        if (empty($album->slug)) {
            $album->slug = $this->generateSlug($album->name);
        }
    }

    public function updated(Album $album): void
    {
        if ($album->wasChanged('status') && $album->status === AlbumStatus::Published && ! empty($album->manager_email)) {
            $this->createManagerAndSendEmail($album);
        }
    }

    public function created(Album $album): void
    {
        if ($album->status === AlbumStatus::Published && ! empty($album->manager_email)) {
            $this->createManagerAndSendEmail($album);
        }
    }

    private function createManagerAndSendEmail(Album $album): void
    {
        if (User::query()->where('email', $album->manager_email)->exists()) {
            return;
        }

        $password = Str::password(12);
        $loginUrl = 'https://www.digitalartstudio.pt/admin';

        $user = User::query()->create([
            'name' => "manager do album {$album->name}",
            'email' => $album->manager_email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

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
