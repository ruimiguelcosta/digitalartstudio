<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'reference' => fake()->unique()->numerify('REF#####'),
            'path' => '/storage/photos/'.fake()->word().'.jpg',
            'original_filename' => fake()->word().'.jpg',
            'size' => fake()->numberBetween(1000000, 10000000),
        ];
    }
}
