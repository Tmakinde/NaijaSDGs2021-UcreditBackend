<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('genders')->insert(['sex' => 'male']);
        DB::table('genders')->insert(['sex' => 'female']);
    }
}
