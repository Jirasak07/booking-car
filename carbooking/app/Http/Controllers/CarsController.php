<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarsController extends Controller
{
    //
    function index(){
      $response = Http::get('http://localhost:225/index.php/api/calendar');
    
      $jsonData = $response->json();
        
     
        return view('admin.manage_car')->with(['car' => $jsonData]);
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
