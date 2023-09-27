<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        for ($i = 0; $i < 18; $i++) {
            $faker = Factory::create();
            $currentUser = $users[$i];

            if ($i % 2 == 1 && $i > 12) {
                $currentUser->accounts()->create([
                    'currency_id' => $faker->randomElement(range(1, 150)),
                    'balance' => $faker->randomFloat(2, 100, 10000),
                    'title' => $faker->word,
                ]);
            }

            if ($i % 2 == 0 && $i < 12) {
                $currentUser->accounts()->create([
                    'currency_id' => $faker->randomElement(range(1, 150)),
                    'balance' => $faker->randomFloat(2, 100, 10000),
                    'title' => $faker->word,
                ]);
            }

            if ($i < 3) {
                $currentUser->accounts()->create([
                    'currency_id' => $faker->randomElement(range(1, 150)),
                    'balance' => $faker->randomFloat(2, 100, 10000),
                    'title' => $faker->word,
                ]);
            }

            $currentUser->accounts()->create([
                'currency_id' => $faker->randomElement(range(1, 150)),
                'balance' => $faker->randomFloat(2, 100, 10000),
                'title' => $faker->word,
            ]);
        }

    }
}
