<?php

namespace Modules\Director\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Director\Entities\Director;

class DirectorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Director::factory(5)->create();
        // $this->call("OthersTableSeeder");
    }
}
