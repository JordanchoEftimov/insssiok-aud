<?php

namespace Database\Seeders;

use App\Models\Jet;
use App\Models\Review;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Jet::factory(20)->create();
        Review::factory(20)->create();
    }
}
