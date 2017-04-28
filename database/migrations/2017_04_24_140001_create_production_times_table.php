<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shifts');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->string('status')->comment="0->Inactive,1->Active";
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
        Schema::dropIfExists('production_times');
    }
}
