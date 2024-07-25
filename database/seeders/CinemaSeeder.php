<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cinemas')->insert([
            [
                'name' => 'Cinema A',
                'rate_point' => 5,
                'city_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cinema B',
                'rate_point' => 4,
                'city_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cinema C',
                'rate_point' => 3,
                'city_id' => 3, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
