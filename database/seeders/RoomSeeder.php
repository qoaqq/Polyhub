<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'name' => 'Room 1',
                'cinema_id' => 1, // Thay đổi ID này theo ID của các rạp chiếu phim trong bảng cinemas của bạn
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Room 2',
                'cinema_id' => 2, // Thay đổi ID này theo ID của các rạp chiếu phim trong bảng cinemas của bạn
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Room 3',
                'cinema_id' => 3, // Thay đổi ID này theo ID của các rạp chiếu phim trong bảng cinemas của bạn
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm các phòng chiếu phim khác tại đây
        ]);
    }
}
