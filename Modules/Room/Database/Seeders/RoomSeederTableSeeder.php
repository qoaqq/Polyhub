<?php

namespace Modules\Room\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoomSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('rooms')->insert([
            'name' => 'Room 1',
            'cinema_id' => 1,
        ]);

        DB::table('rooms')->insert([
            'name' => 'Room 2',
            'cinema_id' => 1,
        ]);
    }
}
