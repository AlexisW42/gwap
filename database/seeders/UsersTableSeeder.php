<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'the admin user',
            'username' => 'adminUser',
            'email' => 'iamadmin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'A player user',
            'username' => 'playerUser',
            'email' => 'iamaplayer@gmail.com',
            'role' => 'player',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Alex',
            'username' => 'alexPlayer',
            'email' => '',
            'role' => 'player',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'Martin',
            'username' => 'martinPlayer',
            'email' => '',
            'role' => 'player',
            'password' => Hash::make('password'),
        ]);
    }
}
