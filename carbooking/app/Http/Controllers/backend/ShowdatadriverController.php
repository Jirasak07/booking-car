<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowdatadriverController extends Controller
{
    //
    public function showbooking(){
        $id = Auth::id();
        $booking = DB::table('tb_booking')->where('booking_status','>',1)->where('driver',$id)->get();
        return view('driver.index')->with(['booking'=>$booking]);
    }
    public function compleace($id){
        $booking_compleace = BookingModel::find($id);
        $booking_compleace->booking_status = 5;
        $booking_compleace->save();
    }
}
