<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = fake()->uuid() . '.jpg';
        $originalFilename = fake()->word() . '.jpg';
        
        return [
            'title' => fake()->sentence(2),
            'description' => fake()->paragraph(),
            'filename' => $filename,
            'original_filename' => $originalFilename,
            'mime_type' => 'image/jpeg',
            'file_size' => fake()->numberBetween(100000, 5000000),
            'path' => 'photos/' . $filename,
            'url' => 'photos/' . $filename,
            'order' => fake()->numberBetween(0, 100),
            'is_featured' => fake()->boolean(20),
            'album_id' => \App\Models\Album::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function forAlbum(\App\Models\Album $album): static
    {
        return $this->state(fn (array $attributes) => [
            'album_id' => $album->id,
            'user_id' => $album->user_id,
        ]);
    }
}
