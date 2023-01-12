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
        $booking = BookingModel::all();
        return response()->json($booking);

    }

    function showcalendar(){
        $events =array();
        $bookings = DB::table('tb_booking')
        ->select('booking_id', 'booking_start', 'booking_end', 'type_car')
        ->get();
        foreach($bookings as $item){
            $events[] = [
                'title' => $item->booking_id,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'type' => $item->type_car
            ];
        }
        return response()->json($events);
    }

}
