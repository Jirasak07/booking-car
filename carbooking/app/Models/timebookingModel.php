<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timebookingModel extends Model
{
    use HasFactory;
    protected $table = "tb_timebooking";
     protected $Fileable = [
        'id',
        'name',
        'time',
        'unit',
        
     ];
}
