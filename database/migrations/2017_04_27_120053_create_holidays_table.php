<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('occasion');
            $table->string('status')->comment="0->Normal,1->Special";
            $table->string('deleted_status')->comment="0->Inactive,1->Active";
            $table->integer('employee_id')->unsigned()->nullable();
            $table->timestamps();

            $table->unique(array('date','occasion'));
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}
