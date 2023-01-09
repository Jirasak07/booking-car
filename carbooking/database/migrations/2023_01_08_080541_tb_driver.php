<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbDriver extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_driver',function(Blueprint $table){
            $table->increments('driver_id');//รหัสชื่อคนขับรถภายใน
            $table->string('driver_fullname');//ชื่อ-สกุล คนขับรถภายใน
            $table->string('driver_status');//สถานะคนขับรถภายใน
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
        Schema::dropIfExists('tb_driver');
        //
    }
}
