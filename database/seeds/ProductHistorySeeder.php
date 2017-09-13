<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class ProductHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (range(1, 50) as $index) {
            \App\ProductHistory::create([
                'name' => $faker->word,
                'product_id' => $faker->numberBetween(1,15),
                'cost' => $faker->randomFloat(2, 0, 100000),
                'price' => $faker->randomFloat(2, 0, 100000),
                'description' => $faker->sentence
            ]);
        }
    }
}
