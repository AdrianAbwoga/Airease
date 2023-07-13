<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use Faker\Factory as Faker;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Flight::create([
                'destination' => $faker->city,
                'departure_date' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'return_date' => $faker->dateTimeBetween('+2 days', '+2 weeks')->format('Y-m-d'),
                'number_of_users' => $faker->numberBetween(1, 5),
            ]);
        }
    }
}