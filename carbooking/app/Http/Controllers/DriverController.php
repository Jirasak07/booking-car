<?php

namespace App\Http\Controllers;

use App\Models\DriverModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DriverController extends Controller
{
    //
    function index(){
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://'.$currentURL.'/index.php/api/driver');


      $jsonData = $response->json();
        return view('admin.manage_driver')->with(['driver' => $jsonData]);
    }
    public function changeStatus($id)
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
     return response()->json(['status'=>'success']);
    }
}
