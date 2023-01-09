<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_booking',function(Blueprint $table){
            $table->increments('booking_id');//รหัสการจองรถ
            $table->date('booking_start');//ระยะเวลาเริ่มต้นการจอง
            $table->date('booking_end');//ระยะเวลาสิ้นสุดการจอง
            $table->string('license_plate')->nullable();//ทะเบียนรถ
            $table->string('username');//ชื่อผู้จอง
            $table->string('driver')->nullable();//คนขับ
            $table->string('type_car')->nullable();//ประเภทรถภานนอก/ภายใน
            $table->text('booking_detail');//วัตถุประสงค์
            $table->string('booking_status');//สถานะการจอง
            $table->timestamps();

        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()


    {
        Schema::dropIfExists('tb_booking');
        //
    }
}
