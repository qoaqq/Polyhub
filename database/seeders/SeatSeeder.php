<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = DB::table('rooms')->get();
        $rows = [
            'a' => 1, 'b' => 1, 'c' => 1,
            'd' => 2, 'e' => 2, 'f' => 2,
            'g' => 3
        ];
        // lặp qua từng phòng đã được tạo
        foreach($rooms as $room){
            $seats = [];
            for ($column = 1; $column <= 12; $column++) {
                foreach ($rows as $row => $type) {
                    $seats[] = [
                        'row' => $row,
                        'column' => $column,
                        'type' => $type,
                        'status' => 0,
                        'room_id' => $room->id,
                     ];
                }
            }
            DB::table('seats')->insert($seats);
        }
    }
}
