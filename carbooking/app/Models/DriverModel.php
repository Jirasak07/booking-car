<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverModel extends Model
{
    use HasFactory;
    protected $table ="tb_driver";
    protected $fileable =[
        'driver_id',
        'driver_fullname',
        'deriver_status'
    ];
}
