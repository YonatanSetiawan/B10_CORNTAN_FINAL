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
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@corntan.com',
                'password' => Hash::make('admin123'),
                'no_telp' => '081203123019',
                'user_roles' => 1,
            ],[
                'name' => 'User',
                'email' => 'user@corntan.com',
                'password' => Hash::make('user123'),
                'no_telp' => '081200981293',
                'user_roles' => 2,
            ]
        ]);
    }
}
