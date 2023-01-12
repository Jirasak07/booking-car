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
        $booking = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->select('booking_id', 'car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel', 'booking_start', 'booking_end', 'booking_detail', 'booking_status', 'driver_fullname', 'type_car', 'car_license')
            ->get();
        return view('admin.booking_request')->with(['booking' => $booking]);
    }
    
    function showcalendar (){
        $response = Http::get('http://localhost:225/index.php/api/calendar');
        
        $jsonData = $response->json();

// return dd($jsonData);
        return view('user.dashboard')->with(['booking' => $jsonData]);
    }

}
