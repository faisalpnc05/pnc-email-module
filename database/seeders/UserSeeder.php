<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
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
            'name' => 'Faisal Ahsan',
            'email' => 'faisalpnc05@gmail.com',
            'password' => Hash::make('PNCSol'),
            'token' => '',
        ]);
    }
}
