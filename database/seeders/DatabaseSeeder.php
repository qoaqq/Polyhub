<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        $this->call([
            CitySeeder::class,
            CinemaSeeder::class,
            CinemaTypeSeeder::class,
            RoomSeeder::class,
            SeatSeeder::class,
            DirectorSeeder::class,
            CategorySeeder::class,
            MovieSeeder::class,
            MovieCategorySeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
        ]);

    }
}
