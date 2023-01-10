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
    function changestatus($id)
    {
        
    }

}
