<?php

namespace Database\Seeders;

use App\Enums\UserPosition;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users= User::query()->first();
        if (!$users){
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'position' => UserPosition::MANAGER
            ]);
            User::factory(10)->create();
        }



    }
}
