<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Attribute\Database\Seeders\AttributeDatabaseSeeder;
use Modules\AttributeValue\Database\Seeders\AttributeValueDatabaseSeeder;
use Modules\Blog\Database\Seeders\BlogDatabaseSeeder;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\Cinema\Database\Seeders\CinemaDatabaseSeeder;
use Modules\CinemaType\Database\Seeders\CinemaTypeDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Director\Database\Seeders\DirectorDatabaseSeeder;
use Modules\FoodCombo\Database\Seeders\FoodComboDatabaseSeeder;
use Modules\Movie\Database\Seeders\MovieCategoryTableSeeder;
use Modules\Movie\Database\Seeders\MovieDatabaseSeeder;
use Modules\Room\Database\Seeders\RoomDatabaseSeeder;
use Modules\Seat\Database\Seeders\SeatDatabaseSeeder;
use Modules\Seat\Database\Seeders\SeatTypeTableSeeder;
use Modules\SeatShowtimeStatus\Database\Seeders\SeatShowtimeStatusDatabaseSeeder;
use Modules\ShowingRelease\Database\Seeders\ShowingReleaseDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(11)->create();
        $this->call([
            CityDatabaseSeeder::class,
            CinemaDatabaseSeeder::class,
            CinemaTypeDatabaseSeeder::class,
            RoomDatabaseSeeder::class,
            SeatTypeTableSeeder::class,
            SeatDatabaseSeeder::class,
            DirectorDatabaseSeeder::class,
            CategoryDatabaseSeeder::class,
            MovieDatabaseSeeder::class,
            MovieCategoryTableSeeder::class,
            AttributeDatabaseSeeder::class,
            AttributeValueDatabaseSeeder::class,
            ShowingReleaseDatabaseSeeder::class,
            BlogDatabaseSeeder::class,
            SeatShowtimeStatusDatabaseSeeder::class,
            FoodComboDatabaseSeeder::class,
        ]);
    }
}
