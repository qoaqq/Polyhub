<?php

namespace Modules\AttributeValue\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\AttributeValue\Entities\AttributeValue;
class AttributeValueDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        AttributeValue::factory()->count(5)->create();
    }
}
