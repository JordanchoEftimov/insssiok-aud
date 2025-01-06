<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Yacht;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'yacht_id' => Yacht::factory(),
            'user_name' => $this->faker->name(),
            'reservation_date' => $this->faker->dateTimeBetween('+1 day', '+1 year')->format('Y-m-d'),
            'duration_hours' => $this->faker->numberBetween(1, 12),
        ];
    }
}
