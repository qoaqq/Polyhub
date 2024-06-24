<?php
namespace Modules\FoodCombo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FoodComboFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\FoodCombo\Entities\FoodCombo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(50),
            'price' => round(fake()->numberBetween(10000, 500000), -3),
        ];
    }
}

