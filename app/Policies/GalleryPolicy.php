<?php

namespace App\Policies;

use App\Models\Gallery;
use App\Models\User;

class GalleryPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, Gallery $gallery): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Gallery $gallery): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Gallery $gallery): bool
    {
        return $this->isAdmin($user);
    }

    public function restore(User $user, Gallery $gallery): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Gallery $gallery): bool
    {
        return $this->isAdmin($user);
    }

    protected function isAdmin(User $user): bool
    {
        return $user->roles()->where('slug', 'admin')->exists();
    }
}
