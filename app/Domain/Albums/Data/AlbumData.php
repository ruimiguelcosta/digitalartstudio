<?php

namespace App\Domain\Albums\Data;

class AlbumData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public string $start_date,
        public string $end_date,
        public string $status
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            start_date: $data['start_date'],
            end_date: $data['end_date'],
            status: $data['status'] ?? 'draft'
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ];
    }
}
