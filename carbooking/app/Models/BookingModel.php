<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    use HasFactory;
    protected $table = 'tb_booking';
    protected $fileable = [
        'booking_id',
        'car_license'
    ];
    function booking(){
        return static::join('tb_cars','tb_booking.license_plate','=','tb_cars.id');
        }

}
