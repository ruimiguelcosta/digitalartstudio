<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Administrador',
            'email' => 'admin@photoevents.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN->value,
        ]);

        User::query()->create([
            'name' => 'Gestor',
            'email' => 'manager@photoevents.com',
            'password' => Hash::make('password'),
            'role' => UserRole::MANAGER->value,
        ]);

        User::query()->create([
            'name' => 'Utilizador',
            'email' => 'user@photoevents.com',
            'password' => Hash::make('password'),
            'role' => UserRole::USER->value,
        ]);
    }
}
