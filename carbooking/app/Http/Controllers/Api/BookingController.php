<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //
    function index(){
        $booking = BookingModel::all();
        return response()->json($booking);

    }

    function showcalendar(){
        $bookings = DB::table('tb_booking')
        ->select('booking_id', 'booking_start', 'booking_end',  'type_car')
        ->get();
        
        return response()->json($bookings);
    }
}
