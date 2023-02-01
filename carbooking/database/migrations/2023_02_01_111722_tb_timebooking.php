<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbTimebooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tb_timebooking',function(Blueprint $table){
            $table->string('id');//รหัสเวลา
            $table->string('name');
            $table->string('time');//เวลา
            $table->string('unit');//หน่วยเวลา
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_timebooking');
        //
    }
}
