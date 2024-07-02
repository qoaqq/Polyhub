<?php
namespace Modules\Ticket\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cinema\Entities\Cinema;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\ShowingRelease\Entities\ShowingRelease;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Ticket\Entities\Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $Times = ['09:00', '10:00', '12:00', '14:00', '16:00'];
        $randomTime = $this->faker->randomElement($Times);
        $dateRelease = $this->faker->date();
        return [
            'movie_id' => Movie::pluck('id')->random(),
            'seat_id' => Seat::pluck('id')->random(),
            'room_id' => Room::pluck('id')->random(),
            'showing_release_id' => ShowingRelease::pluck('id')->random(),
            'cinema_id' => Cinema::pluck('id')->random(),
            'time_start' => $dateRelease . ' ' . $randomTime . ':00', 
        ];
    }
}

