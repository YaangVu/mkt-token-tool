<?php

namespace Database\Factories;

use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sku>
 */
class SkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'package_name' => $this->faker->name,
            'price' => $this->faker->randomNumber(3),
            'game_name' => $this->faker->name,
            'product_id' => $this->faker->uuid,
            'type' => 'inapp',
            'price_currency_code' => $this->faker->currencyCode,
            'created_by' => 1,
            'team_id' => 1,
        ];
    }
}
