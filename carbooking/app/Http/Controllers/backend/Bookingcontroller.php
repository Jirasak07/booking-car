<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use illuminate\auth\SessionGuard;
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
        

        // $User_booking = DB::table('Users')
        // ->whereIn('Users.id', Auth::Users()->id)
        // ->join('tb_booking', 'Users.id', '=', 'tb_booking_username')
        // ->select('Users.Usrname', 'tb_booking.*')
        // ->get();

        $booking = DB::table('tb_booking')
        
        ->join('users', 'tb_booking.username', '=', 'users.id')
        
        ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
        ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
        ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
        ->whereIn('users.id', Auth::user())
        
        ->select( 'car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel',  'driver_fullname', 'car_license','tb_booking.*' ,'users.username')
        ->get();
        // return dd($booking);
        
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
        
        
        $bookingcar->username = $request->user_id;
        $bookingcar->booking_start = $request->date_start;
        $bookingcar->booking_end = $request->date_end;
        $bookingcar->booking_detail = $request->location;
        $bookingcar->booking_status = '1';
        $bookingcar->save();

        return redirect()->back();




    }
}
