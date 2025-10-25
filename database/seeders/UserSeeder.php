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
        User::query()->updateOrCreate(
            ['email' => 'rui.costa@inovador.net'],
            [
                'name' => 'Rui Costa',
                'password' => Hash::make('!PassWord@1234!5678'),
                'role' => UserRole::ADMIN->value,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'digitalartstudio.pt@gmail.com'],
            [
                'name' => 'António Braga',
                'password' => Hash::make('!PassWord@1234!5678'),
                'role' => UserRole::ADMIN->value,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'manager@digitalartstudio.com'],
            [
                'name' => 'Gestor',
                'password' => Hash::make('!PassWord@1234!5678'),
                'role' => UserRole::MANAGER->value,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'user@digitalartstudio.com'],
            [
                'name' => 'Utilizador',
                'password' => Hash::make('!PassWord@1234!5678'),
                'role' => UserRole::USER->value,
            ]
        );
    }
}
