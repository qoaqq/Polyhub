<?php

namespace Modules\Seat\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeatTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seat_types')->insert([
            ['name' => 'Standard', 'price' => 2],
            ['name' => 'VIP', 'price' => 3],
            ['name' => 'Couple', 'price' => 4],
        ]);
    }
}
