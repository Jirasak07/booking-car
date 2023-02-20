<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use App\Models\DriverModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    //
    function index(){
        $driver = DB::table('users')->where('role_user','3')->get();
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
