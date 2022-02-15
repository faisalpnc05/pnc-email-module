<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_template')->insert(
            [
                'name' => 'Marketing Email',
                'template_html' => 'Hello This is testing email template',
            ],
            [
                'name' => 'Greeting Email',
                'template_html' => 'Hello this is greeting email',
            ]
        );
    }
}