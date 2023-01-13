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
        // $currentURL = request()->getHttpHost();
 
        // $response = Http::get('http://'.$currentURL.'/index.php/api/calendar');

        // $jsonData = $response->json();
        $bookings = BookingModel::all();
        $events = array();
        foreach($bookings as $booking){
            $color =null;
            if($booking->type_car == '1'){
                $color = '#cc2255';
            }

            if($booking->type_car == '2'){
                $color = '#aaff45';
            }

            $events [] = [
                'id' => $booking->id,
                'start' => $booking->booking_start,
                'end' => $booking->booking_end,
                'type' => $booking->type_car,
                'color' => $color
            ];
        }

        return view('user.dashboard')->with(['booking' => $events]);
    }
function cancle($id){

    $canclebooking = BookingModel::find($id);
    $canclebooking->status_booking == "3";
    $canclebooking->save();
}
}
