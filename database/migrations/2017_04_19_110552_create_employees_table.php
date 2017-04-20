<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('address');
            $table->string('gender');
            $table->string('phone_number')->unique();
            $table->string('alt_phone_number')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('joining_date');
            $table->date('dob');
            $table->string('activation_status')->comment="0->Active,1->Inactive,2->Pending";
            $table->string('company_email')->unique()->nullable();
            $table->text('designation')->nullable();
            $table->string('salary')->nullable();
            $table->string('picture')->nullable();
            $table->string('marital_status');
            $table->date('resign_date')->nullable();
            $table->string('reason')->nullable();
            $table->text('particle_id')->nullable();
            $table->text('access_token')->nullable();
            $table->timestamps();
        });
     DB::update("ALTER TABLE employees AUTO_INCREMENT = 1101;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
