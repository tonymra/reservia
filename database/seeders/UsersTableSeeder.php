<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the Super Admin user
        DB::table('users')->insert([
            'name' => 'Tony Murwira',
            'email' => 'admin@reservia.co.za',
            'password' => Hash::make('reservia'),
            'user_type' => 'Super Admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Faker for generating random names
        $faker = Faker::create();

        // Create 3 Admin users
        for ($i = 1; $i <= 3; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => 'admin' . $i . '@reservia.co.za',
                'password' => Hash::make('reservia' . $i),
                'user_type' => 'Admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
