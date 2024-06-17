<?php
namespace Modules\Attibute\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Actor\Entities\Movie;
class AttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Attribute\Entities\Attribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'movie_id' => Movie::pluck('id')->random(),
            'name' => $this->faker->randomElement(['Image','OST']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

