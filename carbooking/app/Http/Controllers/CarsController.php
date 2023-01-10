<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    //
    function index(){
        $car = CarModel::All();
        return view('admin.manage_car')->with(['car' => $car]);
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
     return redirect()->back();
    }
}
