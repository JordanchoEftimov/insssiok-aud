<?php

namespace Database\Seeders;

use App\Enums\InvoiceStatusEnum;
use App\Models\Client;
use App\Models\Invoice;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $clients = Client::all();

        foreach (range(1, 20) as $index) {
            Invoice::query()
                ->create([
                    'invoice_number' => $faker->unique()->numerify('INV-#######'),
                    'due_date' => $faker->date(),
                    'status' => InvoiceStatusEnum::cases()[array_rand(InvoiceStatusEnum::cases())]->value,
                    'amount' => $faker->randomFloat(2, 100, 1000),
                    'client_id' => $clients->random()->id,
                ]);
        }
    }
}
