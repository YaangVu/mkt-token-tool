<?php

namespace Database\Seeders;

use App\Models\Sku;
use App\Models\Token;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Run PermissionSeeder, RoleSeeder, and UserSeeder
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            TeamSeeder::class,
            UserSeeder::class,
            SkuSeeder::class,
            TokenSeeder::class
        ]);
    }
}
