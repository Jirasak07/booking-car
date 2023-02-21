<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\DriverModel;
use App\Models\timebookingModel;
use Illuminate\Http\Request;

class Settingapi extends Controller
{
    //


    public function showsetting()
    {
       
        return response()->json(['setting' => timebookingModel::all(),]);
    }

    public function edit_time(Request $request)
    {
        $id = $request->id;
        $time = timebookingModel::find($id);
        $time->time = $request->time;
        $time->unit = $request->unit;
        if($request->unit == 'hours'){
            $time->unit_th = 'ชม.';
        }else if($request->unit == 'day'){
            $time->unit_th = 'วัน';
        }else{
            $time->unit_th = 'เดือน';
        }
        $time->save();
      
             return response()->json(['status'=>'edit_success'],201);
        

    }

    public function DriverchangeStatus($id)
    {
       
      $driver = DriverModel::find($id);
      if($driver->driver_status == 1){
        $driver->driver_status = ('2');
        $driver->save();
      }else if($driver->driver_status == 2){
        $driver->driver_status = ('1');
        $driver->save();
      }
     return response()->json(['status'=>'success'],201);
    }

    public function CarchangeStatus($id)
    {
      $car = CarModel::find($id);

      if($car->car_status == 1){
        $car->car_status = ('2');

        $car->save();
      }elseif($car->car_status == 2){
        $car->car_status = ('1');
        $car->save();
      }
     return response()->json(['status'=>'success'],201);
    }
}
