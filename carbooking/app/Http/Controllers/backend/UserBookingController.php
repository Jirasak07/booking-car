<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;

class UserBookingController extends Controller
{
    //
    function edit_booking(Request $request){
        $id = $request->id_form;
        $booking = BookingModel::find($id);
        $booking->booking_start = $request->booking_start;
        $booking->booking_end = $request->booking_end;
        $booking->booking_detail = $request->booking_detail;
        $booking->seve();
        return redirect()->back();
    }
}
