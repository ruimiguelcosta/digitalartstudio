<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::query()->updateOrCreate([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        $managerRole = Role::query()->updateOrCreate([
            'name' => 'Manager',
            'slug' => 'manager',
        ]);

        $guestRole = Role::query()->updateOrCreate([
            'name' => 'Guest',
            'slug' => 'guest',
        ]);

        $adminUser1 = User::query()->updateOrCreate([
            'name' => 'Rui Costa',
            'email' => 'rui.costa@inovador.net',
            'password' => Hash::make('!RuiCosta@2025!'),
            'email_verified_at' => now(),
        ]);

        $adminUser2 = User::query()->updateOrCreate([
            'name' => 'António Braga',
            'email' => 'digitalartstudio.pt@gmail.com',
            'password' => Hash::make('!PassWord@1234!5678'),
            'email_verified_at' => now(),
        ]);

        $managerUser = User::query()->updateOrCreate([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $guestUser1 = User::query()->updateOrCreate([
            'name' => 'Guest User 1',
            'email' => 'guest1@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $guestUser2 = User::query()->updateOrCreate([
            'name' => 'Guest User 2',
            'email' => 'guest2@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $adminUser1->roles()->attach($adminRole);
        $adminUser2->roles()->attach($adminRole);
        $managerUser->roles()->attach($managerRole);
        $guestUser1->roles()->attach($guestRole);
        $guestUser2->roles()->attach($guestRole);
    }
}
