<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

            'name' => $this->faker->words(3, true),
            'name_ar' => $this->faker->words(3, true),
            'image' => '',
            'price_day' => $this->faker->numberBetween(500,8000),
            'price_week' => $this->faker->numberBetween(500,8000),
            'price_month' => $this->faker->numberBetween(500,8000),
            'description' => $this->faker->paragraph(3, false),
            'description_ar' => $this->faker->paragraph(3, false),
            'model_year' => $this->faker->numberBetween(2018,2024),
            'barcode' => $this->faker->ean13(),
            'images' => '',
            'delivery_days' => $this->faker->numberBetween(1,5),
            'is_featured' => $this->faker->numberBetween(0,1),
            'is_trending' => $this->faker->numberBetween(0,1),
            'is_available' => $this->faker->numberBetween(0,1),
            'available_at' => $this->faker->dateTimeBetween('now','+60 days'),
            'branch_id' => $this->faker->numberBetween(1,603),
            'sub_category_id' => $this->faker->numberBetween(1,303),

        ];
    }
}
