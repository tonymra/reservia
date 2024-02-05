<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 25; $i++) {
            $roomType = $faker->randomElement(['Single', 'Double', 'Suite']);

            // Set price based on room type
            switch ($roomType) {
                case 'Single':
                    $price = 500;
                    $description = "A cozy and compact single room perfect for solo travelers, offering all the essential comforts.";
                    break;
                case 'Double':
                    $price = 900;
                    $description = "Spacious double room with two beds, ideal for couples or friends traveling together.";
                    break;
                case 'Suite':
                    $price = 1500;
                    $description = "Luxurious suite offering premium amenities, extra space, and exclusive services for an unforgettable stay.";
                    break;
                default:
                    $price = 500; // Default price if none of the types match
                    $description = "A comfortable room offering all the necessary amenities for a pleasant stay.";
                    break;
            }

            DB::table('rooms')->insert([
                'room_number' => $faker->unique()->numberBetween(100, 500),
                'room_type' => $roomType,
                'price' => $price,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
