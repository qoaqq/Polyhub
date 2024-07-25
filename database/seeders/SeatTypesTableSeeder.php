<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('seat_types')->insert([
            ['name' => 'Standard', 'price' => 2],
            ['name' => 'VIP', 'price' => 3],
            ['name' => 'Couple', 'price' => 4],
        ]);
    }
}
