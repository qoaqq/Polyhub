<?php

namespace Modules\ShowingRelease\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\ShowingRelease\Entities\ShowingRelease;
use Faker\Factory as Faker;

class ShowingReleaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movies = Movie::all();
        $rooms = Room::all();
        $faker = Faker::create();
        // Random date in 2024
        $dateRelease = $faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d');

        // Random time in the day
        $timeRelease = $faker->time($format = 'H:i:s', $max = '23:59:59');

        foreach ($movies as $movie) {
            // Random date in 2024
            $dateRelease = $faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d');
            // Random time in the day
            $timeRelease = $faker->time($format = 'H:i:s', $max = '23:59:59');
            $room = Room::inRandomOrder()->first();
            DB::table('showing_releases')->insert([
                'movie_id' => $movie->id,
                'room_id' => $room->id,
                'time_release' => $dateRelease . ' ' . $timeRelease,
                'date_release' => $dateRelease,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
