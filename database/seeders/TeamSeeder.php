<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $team = Team::create([
            'name' => "Admin's Team",
            'is_active' => true,
            'activated_at' => now(),
            'created_by' => 1
        ]);

        $team->users()->attach(User::first(), ['created_at' => now(), 'updated_at' => now()]);
    }
}
