<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Api\AppMobile\Bookingapi;
use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowdatadriverController extends Controller
{
    //
    public function showbooking()
    {
        $id = Auth::user()->id;
        $booking = DB::table('tb_booking')->where('booking_status', '>', 1)->where('type_car', 1)->where('driver', $id)->Orderby('booking_status','Asc')->get();

        $sumbooking = DB::table('tb_booking')->where('type_car', 1)->where('driver', $id)->where('booking_status','>',1)->count();
        $padding = DB::table('tb_booking')->where('type_car', 1)->where('driver', $id)->where('booking_status','=',2)->count();
        //return response()->json(['booking' => $booking, 'sumbooking' => $sumbooking, 'padding' => $padding]);
        return view('driver.index')->with(['booking' => $booking, 'sumbooking' => $sumbooking, 'padding' => $padding]);
    }
    public function compleace($id)
    {
        $booking_compleace = BookingModel::find($id);
        $booking_compleace->booking_status = 5;
        $booking_compleace->save();
        return response('success');
    }
}
