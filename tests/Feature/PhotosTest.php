<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhotosTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_uma_foto_com_sucesso(): void
    {
        $album = Album::factory()->create([
            'name' => 'Fotografia Casamento',
        ]);

        $imageContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        \Illuminate\Support\Facades\Storage::put('tmp/test.jpg', $imageContent);

        $payload = [
            'album_id' => $album->id,
            'path' => 'tmp/test.jpg',
            'original_filename' => 'test.jpg',
            'size' => 1024000,
        ];

        $response = $this->postJson('/api/photos', $payload)
            ->assertCreated();

        $this->assertTrue(Photo::query()->where('album_id', $album->id)->exists());
        $this->assertStringContainsString('photos/'.$album->slug.'/', $response->json('path'));
    }

    public function test_gera_referencia_automaticamente_baseada_nas_iniciais_do_album(): void
    {
        $album = Album::factory()->create([
            'name' => 'Fotografia Casamento',
        ]);

        $imageContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        \Illuminate\Support\Facades\Storage::put('tmp/test1.jpg', $imageContent);

        $payload = [
            'album_id' => $album->id,
            'path' => 'tmp/test1.jpg',
            'original_filename' => 'test1.jpg',
        ];

        $response = $this->postJson('/api/photos', $payload)
            ->assertCreated()
            ->assertJsonPath('reference', 'FC00001');

        \Illuminate\Support\Facades\Storage::put('tmp/test2.jpg', $imageContent);

        $payload2 = [
            'album_id' => $album->id,
            'path' => 'tmp/test2.jpg',
            'original_filename' => 'test2.jpg',
        ];

        $response2 = $this->postJson('/api/photos', $payload2)
            ->assertCreated()
            ->assertJsonPath('reference', 'FC00002');
    }

    public function test_lista_todas_as_fotos(): void
    {
        $album = Album::factory()->create();
        $photo = Photo::factory()->for($album)->create();

        $this->getJson('/api/photos')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'album_id', 'reference', 'path', 'original_filename', 'size', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_mostra_uma_foto_especifica(): void
    {
        $album = Album::factory()->create();
        $photo = Photo::factory()->for($album)->create();

        $this->getJson("/api/photos/{$photo->id}")
            ->assertOk()
            ->assertJsonPath('path', $photo->path);
    }

    public function test_atualiza_uma_foto_com_sucesso(): void
    {
        $album = Album::factory()->create();
        $photo = Photo::factory()->for($album)->create();

        $payload = [
            'path' => '/storage/photos/updated.jpg',
            'original_filename' => 'updated.jpg',
            'size' => 2048000,
        ];

        $this->patchJson("/api/photos/{$photo->id}", $payload)
            ->assertOk()
            ->assertJsonPath('path', '/storage/photos/updated.jpg');

        $this->assertEquals('/storage/photos/updated.jpg', $photo->refresh()->path);
    }

    public function test_deleta_uma_foto_com_sucesso(): void
    {
        $album = Album::factory()->create();
        $photo = Photo::factory()->for($album)->create();

        $this->deleteJson("/api/photos/{$photo->id}")
            ->assertNoContent();

        $this->assertNull(Photo::query()->find($photo->id));
    }

    public function test_valida_que_album_id_e_obrigatorio(): void
    {
        $payload = [
            'path' => '/storage/photos/test.jpg',
            'original_filename' => 'test.jpg',
        ];

        $this->postJson('/api/photos', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['album_id']);
    }

    public function test_valida_que_album_id_deve_existir(): void
    {
        $payload = [
            'album_id' => 9999,
            'path' => '/storage/photos/test.jpg',
            'original_filename' => 'test.jpg',
        ];

        $this->postJson('/api/photos', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['album_id']);
    }

    public function test_valida_que_o_tamanho_maximo_e_respeitado(): void
    {
        $album = Album::factory()->create();

        $maxSizeMB = config('photos.max_size_mb');
        $maxSizeBytes = $maxSizeMB * 1024 * 1024;
        $exceedingSize = $maxSizeBytes + 1;

        $payload = [
            'album_id' => $album->id,
            'path' => '/storage/photos/test.jpg',
            'original_filename' => 'test.jpg',
            'size' => $exceedingSize,
        ];

        $this->postJson('/api/photos', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['size']);
    }

    public function test_valida_limite_maximo_de_fotos_por_album(): void
    {
        $album = Album::factory()->create();

        $maxCount = config('photos.max_count');

        for ($i = 0; $i < $maxCount; $i++) {
            Photo::factory()->for($album)->create([
                'path' => "/storage/photos/test{$i}.jpg",
                'original_filename' => "test{$i}.jpg",
            ]);
        }

        $payload = [
            'album_id' => $album->id,
            'path' => '/storage/photos/extra.jpg',
            'original_filename' => 'extra.jpg',
        ];

        $this->postJson('/api/photos', $payload)
            ->assertStatus(500)
            ->assertJson([
                'message' => "Limite máximo de {$maxCount} fotos por álbum atingido.",
            ]);
    }

    public function test_carrega_mais_fotos_para_a_galeria(): void
    {
        $album = Album::factory()->create();
        
        $photos = Photo::factory()->count(30)->for($album)->create();
        
        $payload = [
            'album_id' => $album->id,
            'offset' => 0,
        ];
        
        $response = $this->postJson('/api/photos/load-more', $payload)
            ->assertOk()
            ->assertJsonStructure([
                'photos' => [
                    '*' => ['id', 'path', 'url', 'original_filename', 'reference'],
                ],
                'has_more',
            ]);
        
        $photosData = $response->json('photos');
        $this->assertCount(25, $photosData);
        $this->assertTrue($response->json('has_more'));
    }

    public function test_retorna_has_more_false_quando_nao_ha_mais_fotos(): void
    {
        $album = Album::factory()->create();
        
        $photos = Photo::factory()->count(10)->for($album)->create();
        
        $payload = [
            'album_id' => $album->id,
            'offset' => 0,
        ];
        
        $response = $this->postJson('/api/photos/load-more', $payload)
            ->assertOk();
        
        $this->assertCount(10, $response->json('photos'));
        $this->assertFalse($response->json('has_more'));
    }

    public function test_carrega_fotos_corretas_do_offset_especificado(): void
    {
        $album = Album::factory()->create();
        
        $photos = Photo::factory()->count(30)->for($album)->create();
        
        $firstBatch = $this->postJson('/api/photos/load-more', [
            'album_id' => $album->id,
            'offset' => 0,
        ])->assertOk();
        
        $secondBatch = $this->postJson('/api/photos/load-more', [
            'album_id' => $album->id,
            'offset' => 25,
        ])->assertOk();
        
        $firstPhotoIds = collect($firstBatch->json('photos'))->pluck('id')->toArray();
        $secondPhotoIds = collect($secondBatch->json('photos'))->pluck('id')->toArray();
        
        $this->assertEmpty(array_intersect($firstPhotoIds, $secondPhotoIds));
    }

    public function test_valida_album_id_obrigatorio_em_load_more(): void
    {
        $payload = [
            'offset' => 0,
        ];
        
        $this->postJson('/api/photos/load-more', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['album_id']);
    }

    public function test_valida_offset_obrigatorio_em_load_more(): void
    {
        $album = Album::factory()->create();
        
        $payload = [
            'album_id' => $album->id,
        ];
        
        $this->postJson('/api/photos/load-more', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['offset']);
    }

    public function test_valida_offset_deve_ser_inteiro_positivo(): void
    {
        $album = Album::factory()->create();
        
        $payload = [
            'album_id' => $album->id,
            'offset' => -1,
        ];
        
        $this->postJson('/api/photos/load-more', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['offset']);
    }
}
