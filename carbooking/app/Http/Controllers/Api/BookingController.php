<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //
    function index(){
        $booking = DB::table('tb_booking')
        ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
        ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
        ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
        ->select( 'car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel',  'driver_fullname', 'car_license','tb_booking.*')
        ->get();
    
        return response()->json($booking);

    }

    function showcalendar(){
        $events =array();
        $bookings = DB::table('tb_booking')
        ->select('id', 'booking_start', 'booking_end', 'type_car')
        ->get();
        foreach($bookings as $item){
            $events[] = [
                'id' => $item->id,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'type' => $item->type_car
            ];
        }
        return response()->json($events);
    }

    function store(Request $request){
        $bookingcar = new BookingModel();
        $bookingcar->bookingcar = $request->bookingcar;
        
        $bookingcar->username = $request->username;
        $bookingcar->booking_start = $request->booking_start;
        $bookingcar->booking_end = $request->booking_end;
        $bookingcar->booking_detail = $request->booking_detail;
        $bookingcar->booking_status = '1';
        $bookingcar->save();

        return redirect()->back();




    }
}
