<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class EmploymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employments')->insert(['status' => 'paid']);
        DB::table('employments')->insert(['status' => 'non-paid']);
    }
}
