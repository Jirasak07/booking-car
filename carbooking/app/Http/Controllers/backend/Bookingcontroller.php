<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Bookingcontroller extends Controller
{
    //
    function index()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/booking');

        $jsonData = $response->json();
        return view('admin.booking_request')->with(['booking' => $jsonData]);
    }

    function booking_user(){
        $User_id = Auth::user()->id;

        $booking = DB::table('tb_booking')
        ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
        ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
        ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
        ->join('Users', 'tb_booking.username', '=', 'Users.id')
        ->select( 'car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel',  'driver_fullname', 'car_license','tb_booking.*' ,'Users.username')
        ->where('username', '=', $User_id)
        ->get();

        
        return view('user.booking')->with(['booking' => $booking]);
    }

    public function history()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/booking');

        $jsonData = $response->json();
        return view('admin.booking_history')->with(['history' => $jsonData]);
    }

    function showcalendar()
    {
        // $currentURL = request()->getHttpHost();

        // $response = Http::get('http://'.$currentURL.'/index.php/api/calendar');

        // $jsonData = $response->json();
        $bookings = BookingModel::all();
        $events = array();
        foreach ($bookings as $booking) {
            $color = null;
            if ($booking->type_car == '1') {
                $color = '#00FF7F';
            }

            if ($booking->type_car == '2') {
                $color = '#FF9900';
            }

            $events[] = [
                'id' => $booking->id,
                'start' => $booking->booking_start,
                'end' => $booking->booking_end,
                'type' => $booking->type_car,
                'color' => $color
            ];
        }

        return view('user.dashboard')->with(['booking' => $events]);
    }
    function cancle($id)
    {

        $canclebooking = BookingModel::find($id);
        $canclebooking->booking_status = ('3');
        $canclebooking->save();
        return redirect()->back();
    }
    function store(Request $request){
        $bookingcar = new BookingModel();
        $bookingcar->bookingcar = $request->bookingcar;
        
        $bookingcar->user_id = $request->username;
        $bookingcar->booking_start = $request->booking_start;
        $bookingcar->booking_end = $request->booking_end;
        $bookingcar->booking_detail = $request->booking_detail;
        $bookingcar->booking_status = '1';
        $bookingcar->save();

        return redirect()->back();




    }
}
