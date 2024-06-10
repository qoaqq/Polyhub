<?php

namespace Modules\Movie\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Movie\Entities\Movie;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'duration' =>fake()->numberBetween($min = 60, $max = 180),
            'premiere_date' => fake()->date('Y-m-d'),
            'director_id'=>rand(1,5)
        ];
    }
}

