<?php

namespace Modules\ShowingRelease\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\ShowingRelease\Entities\ShowingRelease;
class ShowingReleaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        ShowingRelease::factory()->count(5)->create();
        // $this->call("OthersTableSeeder");
    }
}
