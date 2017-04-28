<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('breaks')->insert([

        	['break_name'=>'First Break','duration'=>Carbon::createFromTime("00", "20", "00"),'status'=>'1'],
        	['break_name'=>'Second Break','duration'=>Carbon::createFromTime("01", "00", "00"),'status'=>'1'],
        	['break_name'=>'Third Break','duration'=>Carbon::createFromTime("00", "20", "00"),'status'=>'1'],
        ]);
    }
}
