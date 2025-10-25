<?php

namespace Tests\Feature;

use App\Jobs\OptimizeImageJob;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OptimizeImageJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_dispatches_when_photo_is_created(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        Photo::factory()->create(['album_id' => $album->id]);

        Queue::assertPushed(OptimizeImageJob::class);
    }

    public function test_job_processes_image_successfully(): void
    {
        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $photo = Photo::factory()->create([
            'album_id' => $album->id,
            'path' => 'test-image.jpg',
            'file_size' => 1000000,
        ]);

        $testImagePath = storage_path('app/public/test-image.jpg');

        $image = imagecreate(100, 100);
        $bg = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bg);
        imagejpeg($image, $testImagePath, 100);
        imagedestroy($image);

        $job = new OptimizeImageJob($photo);
        $job->handle();

        $this->assertTrue(file_exists($testImagePath));

        if (file_exists($testImagePath)) {
            unlink($testImagePath);
        }
    }

    public function test_job_handles_missing_image_gracefully(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $album = Album::factory()->create(['user_id' => $user->id]);

        $photo = Photo::factory()->create([
            'album_id' => $album->id,
            'path' => 'non-existent-image.jpg',
        ]);

        $job = new OptimizeImageJob($photo);
        $job->handle();

        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
            'path' => 'non-existent-image.jpg',
        ]);
    }
}
