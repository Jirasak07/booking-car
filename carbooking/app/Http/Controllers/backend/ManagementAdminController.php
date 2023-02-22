<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Api\AppMobile\Bookingapi;
use App\Http\Controllers\Controller;
use App\Mail\SendEmailComponent;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\CaroutModel;
use App\Models\DriverModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ManagementAdminController extends Controller
{
    //


   
   
   

    function comment(Request $request){
        $id = $request->id_form;
        $comment_booking = BookingModel::find($id);
        $comment_booking->comment = $request->comment;
        $comment_booking->point_booking = $request->star;
        $comment_booking->save();
        return redirect()->back();
    }

   

}
