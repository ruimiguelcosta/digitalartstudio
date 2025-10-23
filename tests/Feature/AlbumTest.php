<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlbumTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_album(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        
        $this->actingAs($adminUser);
        
        $albumData = [
            'title' => 'Meu Álbum',
            'description' => 'Descrição do álbum',
            'is_public' => true,
        ];

        $response = $this->postJson('/api/albums', $albumData);

        $response->assertStatus(201)
                ->assertJsonFragment(['message' => 'Álbum criado com sucesso!']);

        $this->assertDatabaseHas('albums', [
            'title' => 'Meu Álbum',
            'user_id' => $adminUser->id,
        ]);
    }

    public function test_non_admin_cannot_create_album(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $this->actingAs($user);
        
        $albumData = [
            'title' => 'Meu Álbum',
            'description' => 'Descrição do álbum',
            'is_public' => true,
        ];

        $response = $this->postJson('/api/albums', $albumData);

        $response->assertStatus(403);
    }

    public function test_admin_can_list_albums(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        Album::factory()->count(3)->create();
        
        $this->actingAs($adminUser);

        $response = $this->getJson('/api/albums');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'title', 'description', 'is_public', 'user_id', 'created_at']
                    ]
                ]);
    }

    public function test_admin_can_update_album(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $adminUser->id]);
        
        $this->actingAs($adminUser);
        
        $updateData = [
            'title' => 'Álbum Atualizado',
            'is_public' => false,
        ];

        $response = $this->patchJson("/api/albums/{$album->slug}", $updateData);

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Álbum atualizado com sucesso!']);

        $this->assertDatabaseHas('albums', [
            'id' => $album->id,
            'title' => 'Álbum Atualizado',
            'is_public' => false,
        ]);
    }

    public function test_admin_can_delete_album(): void
    {
        $adminUser = User::factory()->create(['role' => 'admin']);
        $album = Album::factory()->create(['user_id' => $adminUser->id]);
        
        $this->actingAs($adminUser);

        $response = $this->deleteJson("/api/albums/{$album->slug}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Álbum excluído com sucesso!']);

        $this->assertDatabaseMissing('albums', ['id' => $album->id]);
    }
}
