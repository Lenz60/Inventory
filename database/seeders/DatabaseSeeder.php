<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use App\Models\Furniture;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Furniture::factory()->count(5)->create();
        // Admin::factory()->specificAdmin()->create(); // Create admin with specified email and role
        // Admin::factory()->count(4)->create(); // Create additional random admins
        // User::factory()->specificUser()->create(); // Create user with specified email
        // User::factory()->count(4)->create(); // Create additional random users
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
