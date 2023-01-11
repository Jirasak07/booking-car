<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_cars',function(Blueprint $table){
            $table->string('id')->primary();
            $table->string('car_license'); //ทะเบียนรถภายในPK
            $table->string('car_model'); //รายระเอียดยี่ห้อรถ รุ่นรถ
            $table->string('car_status');//สถานะรถ
            $table->timestamps();
        //
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_cars');
        //
    }
}
