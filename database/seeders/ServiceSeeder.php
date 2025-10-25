<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Sessão de Fotografia Individual',
                'price' => 120.00,
                'description' => 'Sessão de fotografia individual com 1 hora de duração e 20 fotos editadas.',
                'is_active' => true,
            ],
            [
                'name' => 'Sessão de Fotografia Casal',
                'price' => 200.00,
                'description' => 'Sessão de fotografia para casais com 1.5 horas de duração e 30 fotos editadas.',
                'is_active' => true,
            ],
            [
                'name' => 'Sessão de Fotografia Família',
                'price' => 250.00,
                'description' => 'Sessão de fotografia familiar com 2 horas de duração e 40 fotos editadas.',
                'is_active' => true,
            ],
            [
                'name' => 'Sessão de Fotografia Corporativa',
                'price' => 300.00,
                'description' => 'Sessão de fotografia corporativa com 2 horas de duração e 50 fotos editadas.',
                'is_active' => true,
            ],
            [
                'name' => 'Sessão de Fotografia Evento',
                'price' => 400.00,
                'description' => 'Cobertura fotográfica completa de eventos com 4 horas de duração e 100 fotos editadas.',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            \App\Models\Service::query()->create($service);
        }
    }
}
