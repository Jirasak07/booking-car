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
    public function changeStatus($id)
    {
      $car = CarModel::find($id);

      if($car->car_status == 1){
        $car->car_status = ('2');

        $car->save();
      }elseif($car->car_status == 2){
        $car->car_status = ('1');
        $car->save();
      }
     return response()->json(['status'=>'success']);
    }
}
