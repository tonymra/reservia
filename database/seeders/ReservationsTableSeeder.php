<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_ZA');

        // Assuming you want to randomly assign rooms, ensure you have room IDs to work with.
        // This fetches all room IDs and caches them for later use.
        $roomIds = DB::table('rooms')->pluck('id')->toArray();

        for ($i = 0; $i < 12; $i++) {
            $checkIn = $faker->dateTimeBetween('now', '+1 month');
            $checkIn->setTime(14, 0); // Check-in time at 14:00
            $nights = rand(1, 3); // Duration between 1 and 3 nights
            $checkOut = (clone $checkIn)->modify("+{$nights} days");
            $checkOut->setTime(6, 0); // Check-out time at 06:00

            // Insert reservation and get its ID
            $reservationId = DB::table('reservations')->insertGetId([
                'reference' => 'R' . date('Ymd') . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => rand(2, 4),
                'adults' => $faker->numberBetween(1, 4),
                'children' => $faker->numberBetween(0, 3),
                'status' => $faker->randomElement(['Confirmed', 'Pending']),
                'notes' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'firstname' => $faker->firstName,
                'lastname' => $faker->lastName,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->state,
                'zipcode' => $faker->postcode,
                'shuttle' => $faker->boolean,
                'parking' => $faker->boolean,
                'breakfast' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Assign rooms to the reservation. Here, we'll assign between 1 to 3 random rooms to each reservation.
            $assignedRoomIds = (array)array_rand($roomIds, rand(1, 3));
            foreach ($assignedRoomIds as $roomIdIndex) {
                DB::table('reservation_room')->insert([
                    'reservation_id' => $reservationId,
                    'room_id' => $roomIds[$roomIdIndex],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
