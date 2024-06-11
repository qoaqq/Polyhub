<?php
namespace Modules\ShowingRelease\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;

class ShowingReleaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\ShowingRelease\Entities\ShowingRelease::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $Times = ['09:00', '10:00', '12:00', '14:00', '16:00'];

        return [
            'movie_id' => Movie::pluck('id')->random(),
            'seat_id' => Seat::pluck('id')->random(),
            'room_id' => Room::pluck('id')->random(),
            'time_release' => $this->faker->randomElement($Times),
            'date_release' => $this->faker->date(),
        ];
    }
}

