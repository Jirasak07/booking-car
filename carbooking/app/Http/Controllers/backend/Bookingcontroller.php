<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Bookingcontroller extends Controller
{
    //
    function index()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://'.$currentURL.'/index.php/api/booking');
  
        $jsonData = $response->json();
        return view('admin.booking_request')->with(['booking' => $jsonData]);
    }

    function showcalendar (){
        $currentURL = request()->getHttpHost();
 
        $response = Http::get('http://'.$currentURL.'/index.php/api/calendar');

        $jsonData = $response->json();
        

        return view('user.dashboard')->with(['booking' => $jsonData]);
    }
function cancle($id){

    $canclebooking = BookingModel::find($id);
    $canclebooking->status_booking == "3";
    $canclebooking->save();
}
}
