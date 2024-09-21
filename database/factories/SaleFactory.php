<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => $this->faker->numberBetween(1,203),
            'pay_method' => $this->faker->numberBetween(1,2),
            'sub_total' => $this->faker->numberBetween(500,8000),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'delivery_charge_total' => $this->faker->numberBetween(50,100),
            'customer_address_id' => $this->faker->numberBetween(4,203),
        ];
    }
}
