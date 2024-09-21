<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail,

            'phone' => $this->faker->unique()->numberBetween(9800000000,9899999999),
            'password' => Hash::make('123456'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'building_no' => $this->faker->buildingNumber,
            'street' => $this->faker->streetName,
            'district' => $this->faker->city,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'lang' => 'EN',
            'is_seller' => $this->faker->numberBetween(0,1),
            'verified_by'=>1,

        ];
    }
}
