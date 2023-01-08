<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarControllers extends Controller
{
    //
    function index(){
        $car = CarModel::All();
        return response()->json($car);
    }

   
}
