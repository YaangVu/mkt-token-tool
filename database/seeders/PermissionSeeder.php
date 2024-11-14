<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Run command: php artisan permissions:sync -H
        // This will sync the permissions with the roles
        Artisan::call('permissions:sync', ['-H' => true, '-Y' => true]);
    }
}
