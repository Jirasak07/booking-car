<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\DriverModel;
use App\Models\timebookingModel;
use App\Models\User;
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
      
             return response()->json($time);
        

    }

    public function DriverchangeStatus($id)
    {
       
      $driver = User::find($id);
      if($driver->status == 1){
        $driver->status = ('2');
        $driver->save();
      }else if($driver->status == 2){
        $driver->status = ('3');
        $driver->save();
      }else if($driver->status == 3){
        $driver->status = ('1');
        $driver->save();
      }
     return response()->json(['success']);
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
     return response()->json(['status'=>'success']);
    }


    public function edit_role($id)
    {
        $findSumAdmin = User::where('role_user', 1)->sum('id');

        $user = User::find($id);
        if ($user->role_user == 1) {
            if ($findSumAdmin > 1) {
                $user->role_user = 2;
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        } else if ($user->role_user == 2) {
            $user->role_user = 1;
            $user->save();
            return response()->json(['status' => 'success']);
        }
    }
}
