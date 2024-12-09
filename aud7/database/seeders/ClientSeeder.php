<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            Client::query()
                ->create([
                    'full_name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'address' => $faker->address,
                ]);
        }
    }
}
