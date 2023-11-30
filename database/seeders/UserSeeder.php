<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Student Account
        DB::table('users')->insert([
            'name' => 'Student',
            'email' => 's@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => 1,
            'phone_number' => '09791652876',
            'address' => 'Yangon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Lecturer Account
        DB::table('users')->insert([
            'name' => 'Lecturer',
            'email' => 'l@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => 2,
            'phone_number' => '09791234567',
            'address' => 'Mandalay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
