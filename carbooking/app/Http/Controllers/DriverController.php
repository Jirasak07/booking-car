<?php

namespace App\Http\Controllers;

use App\Models\DriverModel;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    //
    function index(){
        $driver = DriverModel::All();
        return view('admin.manage_driver')->with(['driver' => $driver]);
    }
    public function changeStatus($id)
    {
      $driver = DriverModel::find($id);

      if($driver->driver_status == 1){
        $driver->driver_status = ('2');
        $driver->save();
      }elseif($driver->driver_status == 2){
        $driver->driver_status = ('1');
        $driver->save();
      }
     return redirect()->back();
    }
}
