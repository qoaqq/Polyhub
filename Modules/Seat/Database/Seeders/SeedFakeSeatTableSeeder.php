<?php

namespace Modules\Seat\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Room\Entities\Room;

class SeedFakeSeatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $rooms = Room::all();
        foreach ($rooms as $room) {

            $rows = [
                'a' => 1, 'b' => 1, 'c' => 1,
                'd' => 2, 'e' => 2, 'f' => 2,
                'g' => 3
            ];
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
