<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Account Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator SIMANTAP',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Account Petugas
        User::updateOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas SIMANTAP',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'is_active' => true,
            ]
        );

        // Account User / Mahasiswa
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User SIMANTAP',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_active' => true,
            ]
        );
    }
}
