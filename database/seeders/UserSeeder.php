<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Manually inserted users
        $manualUsers = [
            [
                'school_id' => 1,
                'username' => 'admin123',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ],
            [
                'school_id' => 2,
                'username' => 'user1',
                'email' => 'user1@gmail.com',
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ],
            [
                'school_id' => 3,
                'username' => 'user2',
                'email' => 'user2@gmail.com',
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ],
            [
                'school_id' => 4,
                'username' => 'user3',
                'email' => 'user3@gmail.com',
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ],
        ];

        // Insert manual users
        foreach ($manualUsers as $userData) {
            User::create($userData);
        }
    }
}
