<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaroutModel extends Model
{
    use HasFactory;
    protected $table = 'tb_out_cars';
    protected $fileable = [
        'id',
        'car_out_license',
        'car_out_model',
        'car_out_driver',
        'car_out_tel'
    ];
}
