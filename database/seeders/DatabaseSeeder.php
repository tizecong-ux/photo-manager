<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // テストユーザーを3件作成
        for ($i = 1; $i <= 3; $i++) {
            User::factory()->create([
                'name' => "Test User {$i}",
                'email' => "test{$i}@example.com",
                'password' => bcrypt("password{$i}"),
            ]);
        }
    }
}
