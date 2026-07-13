<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@ecosansar.com',
            'password' => Hash::make('ecosansar@123'),
            'new_password' => null,
            'confirm_password' => null,
            'type' => 'admin',
            'profile_pic' => '1736858651.png',
            'active' => 1,
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}