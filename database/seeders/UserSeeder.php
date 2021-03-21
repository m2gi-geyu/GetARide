<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'enes',
            'email' => 'enes@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'vehicle' => 'oui',
            'ratings' => NULL
        ]);
    }
}
