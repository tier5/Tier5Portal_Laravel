<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			
			['employee_id'=>'1',
        	'user_name'=>'jon',
        	'password'=> bcrypt('123456'),
            'gender'=>'1',
        	'role'=>'0',
        	'available'=>'2',
            'online_status'=>'0'
            ],

        	['employee_id'=>'2',
        	'user_name'=>'aunkita',
        	'password'=>bcrypt('qwerty'),
            'gender'=>'2',
        	'role'=>'0',
        	'available'=>'2',
            'online_status'=>'0'
            ]

        	]);
    }
}
