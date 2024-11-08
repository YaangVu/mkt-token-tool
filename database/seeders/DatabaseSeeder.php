<?php

namespace Database\Seeders;

use App\Models\Package;
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
            UserSeeder::class,
            TeamSeeder::class,
            PackageSeeder::class,
            TokenSeeder::class
        ]);
    }
}
