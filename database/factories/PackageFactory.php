<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'title' => $this->faker->name,
            'price' => $this->faker->randomNumber(3),
            'game_name' => $this->faker->name,
            'product_id' => $this->faker->uuid,
            'type' => 'inapp',
            'price_currency_code' => $this->faker->currencyCode,
            'created_by' => 1
        ];
    }
}
