<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Bookingcontroller extends Controller
{
    //
    function index()
    {
        $response = Http::get('http://localhost:225/index.php/api/booking');
    
        $jsonData = $response->json();
        return view('admin.booking_request')->with(['booking' => $jsonData]);
    }

    function showcalendar(){
        $response = Http::get('http://localhost:225/index.php/api/calendar');
    
        $jsonData = $response->json();
          
       return view('user.dashboard')->with(['calendar' =>  $jsonData]);
    }

}
