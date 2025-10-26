<?php

namespace App\Domain\Photos\Data;

class PhotoData
{
    public function __construct(
        public ?string $album_id,
        public string $path,
        public string $original_filename,
        public ?int $size
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            album_id: $data['album_id'] ?? null,
            path: $data['path'] ?? '',
            original_filename: $data['original_filename'] ?? '',
            size: $data['size'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'album_id' => $this->album_id,
            'path' => $this->path,
            'original_filename' => $this->original_filename,
            'size' => $this->size,
        ], fn ($value) => $value !== null && $value !== '');
    }
}
