<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'admin',
                'password' => Hash::make('admin2024')
            ],
            [
                'username' => 'user1',
                'password' => Hash::make('user1')
            ],
            [
                'username' => 'user2',
                'password' => Hash::make('user2')
            ],
            [
                'username' => 'user3',
                'password' => Hash::make('user3')
            ],
        ];

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
