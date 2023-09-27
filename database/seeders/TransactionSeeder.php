<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 40; $i++) {
            $faker = Factory::create();

            $transactionData = [
                'sender_account_id' => $faker->randomElement(range(1, 8)),
                'receiver_account_id' => $faker->randomElement(range(1, 8)),
                'amount_in_sender_currency' => $faker->randomFloat(2, 5, 1000),
                'amount_in_receiver_currency' => $faker->randomFloat(2, 5, 1000),
                'amount_in_base_currency' => 1,
            ];

            Transaction::create($transactionData);
        }
    }
}
