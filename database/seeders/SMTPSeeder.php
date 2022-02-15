<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SMTPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('smtp_config')->insert(
            [
                'name' => 'AWS',
                'api_url' => 'https://google.com',
                'public_key' => '9273449873r',
                'secret_key' => 'aoiwfjoiw',
            ],
        );

    }
}