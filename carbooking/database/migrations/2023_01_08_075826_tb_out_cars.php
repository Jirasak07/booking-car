<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbOutCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_out_cars',function(Blueprint $table){
            $table->string('id')->primary();
            $table->string('car_out_license');//ทะเบียนรถภายนอกPK
            $table->string('car_out_model');//รายระเอียดยี่ห้อ รุ่นรถภายนอก
            $table->string('car_out_driver');//ชื่อคนขับหรือชื่อบริษัทรถภายนอก
            $table->string('owner');//เจ้าของ
            $table->string('car_out_tel');//เบอร์ติดต่อภายนอก
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
        Schema::dropIfExists('tb_out_cars');
        //
    }
}
