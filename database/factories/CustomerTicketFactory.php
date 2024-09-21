<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerTicket>
 */
class CustomerTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => $this->faker->numberBetween(1,3),
            'escalation_level' => $this->faker->numberBetween(1,3),
            'ticket_id' => 'CT - ' . $this->faker->ean8(),

            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->numberBetween(1,2),
            'open' => $this->faker->numberBetween(1,2),

            'handler' => 1,
        ];
    }
}
