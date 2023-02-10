<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\DriverModel;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    //
    function index(){
        $driver = DriverModel::All();
        return response()->json($driver);
    }   
    public function changeStatus($id)
    {
       
      $driver = DriverModel::find($id);
      if($driver->driver_status == 1){
        $driver->driver_status = ('2');
        $driver->save();
      }else if($driver->driver_status == 2){
        $driver->driver_status = ('1');
        $driver->save();
      }
     return response()->json(['status'=>'success']);
    }

}
