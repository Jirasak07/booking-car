<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    protected $table = "tb_cars";
    protected $fileable = [
        'car_id',
        'car_license',
        'car_model',
        'car_status'
    ];
}
