<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedules')->insert([
            'start_date' => Carbon::parse('2024-01-19'),//Year, Month, Day
            'end_date' => Carbon::parse('2024-04-20'),
            'course_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
