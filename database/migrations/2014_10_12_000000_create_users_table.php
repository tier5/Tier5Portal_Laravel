<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->unique();
            $table->string('user_name')->unique();
            $table->string('password');
            $table->string('gender')->comment="1->Male,2->Female";
            $table->string('role')->comment="0->SuperAdmin,1->HR,2->Developer,3->BDM";
            $table->string('available')->comment="1->Available,2->Unavailable";
            $table->string('online_status')->comment="0->Offline,1->Online";
            $table->rememberToken();
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
