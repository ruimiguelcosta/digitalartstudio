<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function test_admin_can_upload_photo(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $adminUser->id]);
        
        $this->actingAs($adminUser);
        
        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);
        
        $photoData = [
            'title' => 'Minha Foto',
            'description' => 'Descrição da foto',
            'photo' => $file,
            'album_id' => $album->id,
            'is_featured' => true,
        ];

        $response = $this->postJson('/api/photos', $photoData);

        $response->assertStatus(201)
                ->assertJsonFragment(['message' => 'Foto enviada com sucesso!']);

        $this->assertDatabaseHas('photos', [
            'title' => 'Minha Foto',
            'album_id' => $album->id,
            'user_id' => $adminUser->id,
            'is_featured' => true,
        ]);

        $this->assertDatabaseHas('photos', [
            'title' => 'Minha Foto',
            'album_id' => $album->id,
            'user_id' => $adminUser->id,
            'is_featured' => true,
        ]);
    }

    public function test_non_admin_cannot_upload_photo(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $album = Album::factory()->create();
        
        $this->actingAs($user);
        
        $file = UploadedFile::fake()->image('photo.jpg');
        
        $photoData = [
            'title' => 'Minha Foto',
            'photo' => $file,
            'album_id' => $album->id,
        ];

        $response = $this->postJson('/api/photos', $photoData);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_photo(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $adminUser->id]);
        $photo = Photo::factory()->create(['album_id' => $album->id, 'user_id' => $adminUser->id]);
        
        $this->actingAs($adminUser);
        
        $updateData = [
            'title' => 'Foto Atualizada',
            'is_featured' => false,
        ];

        $response = $this->patchJson("/api/photos/{$photo->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Foto atualizada com sucesso!']);

        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
            'title' => 'Foto Atualizada',
            'is_featured' => false,
        ]);
    }

    public function test_admin_can_delete_photo(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $adminUser->id]);
        $photo = Photo::factory()->create(['album_id' => $album->id, 'user_id' => $adminUser->id]);
        
        $this->actingAs($adminUser);

        $response = $this->deleteJson("/api/photos/{$photo->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Foto excluída com sucesso!']);

        $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
    }

    public function test_photo_validation_requires_valid_image(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $adminUser->id]);
        
        $this->actingAs($adminUser);
        
        $file = UploadedFile::fake()->create('document.pdf', 1000);
        
        $photoData = [
            'title' => 'Minha Foto',
            'photo' => $file,
            'album_id' => $album->id,
        ];

        $response = $this->postJson('/api/photos', $photoData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['photo']);
    }
}
