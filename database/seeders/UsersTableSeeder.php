<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'phone_number' => '1234567890',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password123'),
                'phone_number' => '9876543210',
            ],
            [
                'name' => 'Robert Johnson',
                'email' => 'robert.johnson@example.com',
                'password' => Hash::make('password123'),
                'phone_number' => '5551234567',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'password' => Hash::make('password123'),
                'phone_number' => '4449876543',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'password' => Hash::make('password123'),
                'phone_number' => '3334567890',
            ],
        ]);
    }
}
