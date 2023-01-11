<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    function index(){
        $booking = BookingModel::All();
        
        return response()->json($booking);

    }
}
