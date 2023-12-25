<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            'room_number' => 'R-001',
            'floor_number' => 1,
            'seat_capacity' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('rooms')->insert([
            'room_number' => 'R-002',
            'floor_number' => 2,
            'seat_capacity' => 65,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
