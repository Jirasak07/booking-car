<?php

namespace App\Http\Controllers;

use App\Models\DriverModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DriverController extends Controller
{
    //
    function index(){
      $response = Http::get('http://localhost:225/index.php/api/driver');
    
      $jsonData = $response->json();
        return view('admin.manage_driver')->with(['driver' => $jsonData]);
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
