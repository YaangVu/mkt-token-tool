<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\TeamUserSchema;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Team::create([
            'name' => "Admin's Team",
            'is_active' => true,
            'activated_at' => now(),
            'created_by' => null,
            'coin' => 1000000,
        ]);
    }
}
