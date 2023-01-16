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
        $responsecar = Http::get('http://' . $currentURL . '/index.php/api/car');
        $jsonDatacar = $responsecar->json();
        $responsedriver = Http::get('http://' . $currentURL . '/index.php/api/driver');
        $jsonDatadriver = $responsedriver->json();
        return view('admin.booking_request')->with(['booking' => $jsonData,'car' => $jsonDatacar,'driver' => $jsonDatadriver,]);
    }

    function booking_user()
    {


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
            ->whereIn('tb_booking.username', Auth::user())

            ->select('car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel',  'driver_fullname', 'car_license', 'tb_booking.*', 'users.username')
            ->get();

            $booking_wait = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->whereIn('tb_booking.username', Auth::user())

            ->select( 'tb_booking.*', 'users.username')
            ->get();
        // return dd($booking);
        //dd($booking);
        return view('user.booking')->with(['booking' => $booking],['booking2' =>  $booking_wait]);
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
        $bookings = DB::table('tb_booking')
        ->where('booking_status', '!=', '1')
        
        ->get();
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
    function store(Request $request)
    {
        //dd($request->all());
        $bookingcar = new BookingModel();
        $cnt_booking = $bookingcar->count();
        
        if ($cnt_booking < 1) {
            $bookingcar->id =1;
        } else {
            $bookingcar->id = $cnt_booking +1;
        }
        $bookingcar->username = $request->user_id;
        $bookingcar->booking_start = $request->start;
        $bookingcar->booking_end = $request->end;
        $bookingcar->booking_detail = $request->location;
        $bookingcar->booking_status = '1';
        $bookingcar->save();

        return redirect()->back();
    }
}
