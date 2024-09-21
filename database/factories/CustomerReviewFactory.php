<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerReview>
 */
class CustomerReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1,5),
            'customer_id' => $this->faker->numberBetween(1,203),
            'seller_id' => $this->faker->numberBetween(1,203),
        ];
    }
}
