<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleLecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('module_lecturer')->insert([
            'user_id' => 2,
            'module_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
