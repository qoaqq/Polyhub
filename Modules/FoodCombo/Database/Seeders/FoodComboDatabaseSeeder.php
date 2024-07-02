<?php

namespace Modules\FoodCombo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        FoodCombo::factory()->count(3)->create();
        // $this->call("OthersTableSeeder");
    }
}
