<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;


class UserBookingController extends Controller
{
    //
    function edit_booking(Request $request){
        $id = $request->id;
        $booking = BookingModel::find($id);
        $booking->booking_start = date('Y-m-d', strtotime($request->booking_start));
        $booking->booking_end = date('Y-m-d', strtotime($request->booking_end));
        $booking->booking_detail = $request->booking_detail;
        $booking->save();
        return redirect()->back();
    }

    function unapprove($id){
        $unapprove = BookingModel::find($id);
        $unapprove->booking_status = '3';
        $unapprove->save();
        return redirect()->back();
    }
}
