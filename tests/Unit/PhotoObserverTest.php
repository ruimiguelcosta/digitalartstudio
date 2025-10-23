<?php

namespace Tests\Unit;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_photo_observer_processes_image_on_creation(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $file = UploadedFile::fake()->image('test.jpg', 1200, 800);

        $photo = Photo::create([
            'title' => 'Test Photo',
            'description' => 'Test Description',
            'filename' => 'test.jpg',
            'original_filename' => 'test.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => $file->getSize(),
            'path' => $file->store('photos', 'public'),
            'url' => '',
            'order' => 1,
            'is_featured' => false,
            'album_id' => $album->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
            'title' => 'Test Photo',
        ]);

        $this->assertTrue(Storage::disk('public')->exists($photo->path));
    }

    public function test_photo_observer_handles_missing_file_gracefully(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $photo = Photo::create([
            'title' => 'Test Photo',
            'description' => 'Test Description',
            'filename' => 'nonexistent.jpg',
            'original_filename' => 'nonexistent.jpg',
            'mime_type' => 'image/jpeg',
            'file_size' => 0,
            'path' => 'photos/nonexistent.jpg',
            'url' => '',
            'order' => 1,
            'is_featured' => false,
            'album_id' => $album->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
            'title' => 'Test Photo',
        ]);
    }
}
