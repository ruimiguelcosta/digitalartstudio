<?php

namespace App;

enum AlbumStatus: string
{
    case Draft = 'draft';
    case Private = 'private';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Rascunho',
            self::Private => 'Privado',
            self::Published => 'Publicado',
        };
    }
}
