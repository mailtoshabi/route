<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(2, true),
            'name_ar' => $this->faker->words(2, true),
            'phone' => $this->faker->unique()->numberBetween(9800000000,9899999999),
            'building_no' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'district' => $this->faker->city,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
        ];
    }
}
