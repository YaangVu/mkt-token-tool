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
        $user = User::first();
        $team = Team::create([
            'name' => "$user->name's Team",
            'is_active' => true,
            'activated_at' => now(),
            'created_by' => null,
        ]);
        TeamUserSchema::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'role_id' => 1,
        ]);
    }
}
