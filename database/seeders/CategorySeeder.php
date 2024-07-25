<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Hành Động', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kinh dị', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Khoa học', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
