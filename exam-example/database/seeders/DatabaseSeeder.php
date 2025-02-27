<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Yacht;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Yacht::factory(10)->create();
        Reservation::factory(10)->create();
        Review::factory(20)->create();
    }
}
