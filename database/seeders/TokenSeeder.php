<?php

namespace Database\Seeders;

use App\Models\Token;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Token::factory(100)->create();
    }
}
