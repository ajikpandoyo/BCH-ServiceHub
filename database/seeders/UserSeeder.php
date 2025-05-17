<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin BCH',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        );

        // Users referenced in PeminjamanRuanganSeeder
        $users = [
            [
                'name' => 'Andi Setiawan',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ],
            [
                'name' => 'Cici Rahmawati',
                'email' => 'cici@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ],
            [
                'name' => 'Doni Prasetyo',
                'email' => 'doni@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ],
            [
                'name' => 'Eka Purnama',
                'email' => 'eka@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user'
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
