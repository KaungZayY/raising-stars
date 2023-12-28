<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('module_course')->insert([
            'module_id' => 1,
            'course_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
