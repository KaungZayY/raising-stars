<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            'course' => 'Grade - 9',
            'from_age' => 14,
            'to_age' => 16,
            'fees' => 4000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
