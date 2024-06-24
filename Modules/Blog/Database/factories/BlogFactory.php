<?php
namespace Modules\Blog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Blog\Entities\Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence,
            'content' => fake()->paragraph,
            'image' => fake()->imageUrl(), // Tạo một URL hình ảnh ngẫu nhiên
            'categories_id' => rand(1, 2),
        ];
    }
}

