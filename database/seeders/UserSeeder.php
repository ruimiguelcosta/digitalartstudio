<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Rui Costa',
            'email' => 'rui.costa@inovador.net',
            'password' => Hash::make('!PassWord@1234!5678'),
            'role' => UserRole::ADMIN->value,
        ]);

        User::query()->create([
            'name' => 'António Braga',
            'email' => 'digitalartstudio.pt@gmail.com',
            'password' => Hash::make('!PassWord@1234!5678'),
            'role' => UserRole::ADMIN->value,
        ]);

        User::query()->create([
            'name' => 'Gestor',
            'email' => 'manager@digitalartstudio.com',
            'password' => Hash::make('!PassWord@1234!5678'),
            'role' => UserRole::MANAGER->value,
        ]);

        User::query()->create([
            'name' => 'Utilizador',
            'email' => 'user@digitalartstudio.com',
            'password' => Hash::make('!PassWord@1234!5678'),
            'role' => UserRole::USER->value,
        ]);
    }
}
