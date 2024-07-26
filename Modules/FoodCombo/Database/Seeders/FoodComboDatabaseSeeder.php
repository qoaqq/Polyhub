<?php

namespace Modules\FoodCombo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\FoodCombo\Entities\FoodCombo;

class FoodComboDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foodCombos = [
            ['name' => 'Pizza Margherita', 'description' => 'Classic pizza with tomato, mozzarella, and basil.', 'price' => 4.99],
            ['name' => 'Sushi Roll', 'description' => 'Fresh sushi roll with tuna, avocado, and cucumber.', 'price' => 4.50],
            ['name' => 'Burger Deluxe', 'description' => 'Juicy beef burger with lettuce, tomato, and cheese.', 'price' => 4.75],
            ['name' => 'Pasta Carbonara', 'description' => 'Creamy pasta with pancetta, egg, and Parmesan cheese.', 'price' => 4.80],
            ['name' => 'Chicken Teriyaki', 'description' => 'Grilled chicken with teriyaki sauce and vegetables.', 'price' => 4.90],
            ['name' => 'Tacos Supreme', 'description' => 'Spicy tacos with beef, cheese, and salsa.', 'price' => 4.25],
            ['name' => 'Greek Salad', 'description' => 'Fresh salad with feta cheese, olives, and cucumbers.', 'price' => 4.30],
            ['name' => 'Chocolate Lava Cake', 'description' => 'Warm chocolate cake with a gooey center.', 'price' => 4.99],
        ];

        foreach ($foodCombos as $combo) {
            DB::table('food_combos')->insert([
                'name' => $combo['name'],
                'description' => $combo['description'],
                'price' => $combo['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
