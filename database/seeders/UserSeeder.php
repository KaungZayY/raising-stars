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
            'email' => 'student@gmail.com',
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
            'email' => 'lecturer@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => 2,
            'phone_number' => '09791234567',
            'address' => 'Mandalay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Moderator Account
        DB::table('users')->insert([
            'name' => 'moderator',
            'email' => 'moderator@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => 3,
            'phone_number' => '09791234568',
            'address' => 'Yangon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Admin Account
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role_id' => 4,
            'phone_number' => '09791234566',
            'address' => 'Mandalay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
