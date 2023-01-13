<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarsController extends Controller
{
    //
    function index(){
        $currentURL = request()->getHttpHost();
      $response = Http::get('http://'.$currentURL.'/index.php/api/car');

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
