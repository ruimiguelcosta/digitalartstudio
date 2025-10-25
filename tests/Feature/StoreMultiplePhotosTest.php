<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreMultiplePhotosTest extends TestCase
{
    public function test_can_upload_multiple_photos_to_an_album(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create();

        $this->actingAs($user);

        $photos = [
            UploadedFile::fake()->image('photo1.jpg', 800, 600),
            UploadedFile::fake()->image('photo2.jpg', 800, 600),
            UploadedFile::fake()->image('photo3.jpg', 800, 600),
        ];

        $response = $this->postJson(route('photos.store'), [
            'album_id' => $album->id,
            'photos' => $photos,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Fotos enviadas com sucesso!',
                'count' => 3,
            ]);

        $this->assertEquals(3, Photo::query()->where('album_id', $album->id)->count());

        $storedPhotos = Photo::query()->where('album_id', $album->id)->get();
        foreach ($storedPhotos as $storedPhoto) {
            Storage::disk('public')->assertExists($storedPhoto->path);
        }
    }

    public function test_validates_required_fields_for_multiple_photo_upload(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        $response = $this->postJson(route('photos.store'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['album_id']);
    }

    public function test_validates_album_exists_for_multiple_photo_upload(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        $response = $this->postJson(route('photos.store'), [
            'album_id' => '019a1aaf-0000-0000-0000-000000000000',
            'photos' => [UploadedFile::fake()->image('photo.jpg')],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['album_id']);
    }

    public function test_validates_photo_file_types_for_multiple_photo_upload(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('photos.store'), [
            'album_id' => $album->id,
            'photos' => [UploadedFile::fake()->create('document.pdf', 1000)],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['photos.0']);
    }

    public function test_validates_photo_file_size_for_multiple_photo_upload(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('photos.store'), [
            'album_id' => $album->id,
            'photos' => [UploadedFile::fake()->image('photo.jpg')->size(15000)],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['photos.0']);
    }
}
