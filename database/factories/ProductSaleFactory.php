<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSale>
 */
class ProductSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $start_date = Carbon::instance($this->faker->dateTimeBetween('-1 months','+2 months'));
        $end_date = (clone $start_date)->addDays(random_int(0,14));
        return [
            'product_id' => $this->faker->numberBetween(1,1002),
            'invoice_no' => $this->faker->unique()->numerify('INV#####'),
            'price' => $this->faker->numberBetween(500,8000),
            'delivery_charge' => $this->faker->numberBetween(50,100),
            'rent_term_id' => $this->faker->numberBetween(1,3),
            'starts_at' => $start_date,
            'ends_at' => $end_date,
            'is_paid' => $this->faker->numberBetween(0,1),
            'is_refundable' => $this->faker->numberBetween(0,1),
            'status' => $this->faker->randomElement([0,1,3,4,5,7,9,10,11]),
            'status_delivery' => $this->faker->numberBetween(0,1),
            'status_pickup' => $this->faker->numberBetween(0,1),
        ];
    }
}



