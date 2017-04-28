<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductionTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('production_times')->insert([

        	['shifts'=>'First Shift','clock_in'=>Carbon::createFromTime("11", "00", "00"),'clock_out'=>Carbon::createFromTime("20", "00", "00"),'status'=>'1'],
        	['shifts'=>'Second Shift','clock_in'=>Carbon::createFromTime("12", "00", "00"),'clock_out'=>Carbon::createFromTime("21", "00", "00"),'status'=>'1'],
        	['shifts'=>'Third Shift','clock_in'=>Carbon::createFromTime("13", "00", "00"),'clock_out'=>Carbon::createFromTime("22", "00", "00"),'status'=>'1'],
        	['shifts'=>'Fourth Shift','clock_in'=>Carbon::createFromTime("14", "00", "00"),'clock_out'=>Carbon::createFromTime("23", "00", "00"),'status'=>'1']
        ]);
    }
}
