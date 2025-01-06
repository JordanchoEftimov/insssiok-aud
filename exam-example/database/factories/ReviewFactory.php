<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reviewer_name' => $this->faker->name(),
            'text' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
            'reservation_id' => Reservation::factory(),
        ];
    }
}
