<?php

namespace Database\Factories;

use App\Models\Sku;
use App\Models\Token;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Token>
 */
class TokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'purchase_token' => $this->faker->text,
            'original_json' => json_encode(['key' => $this->faker->word]),
            'signature' => $this->faker->text,
            'order_id' => $this->faker->uuid,
            'owner_id' => 1,
            'sku_id' => $this->faker->numberBetween(1, 10),
            'export_history_id' => null,
            'created_by' => 1,
            'team_id' => 1,
        ];
    }
}
