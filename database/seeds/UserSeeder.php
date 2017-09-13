<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        \App\User::create([
            'name' => $faker->name,
            'phone' => $faker->phoneNumber,
            'email' => 'owner@gmail.com',
            'password' => bcrypt('123456'),
            'site' => $faker->url,
            'address' => $faker->address,
            'current_account' => $faker->bankAccountNumber,
            'bank' => $faker->name,
            'town' => $faker->city,
            'mfo' => $faker->randomNumber(),
            'itn' => $faker->randomNumber(),
        ]);
    }
}
