<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    use HasFactory;
    protected $table = 'tb_booking';
    protected $fileable = [
        'id','booking_start', 'booking_end',
        'license_plate', 'username',
        'driver',
       
       
        
        'type_car' ,
        'booking_detail' ,
        'booking_status'
    ];
   

}
