<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CaroutModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Bookingcontroller extends Controller
{
    //
    public function index()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/pageupdate');
        $jsonData = $response->json();
        $responsecar = Http::get('http://' . $currentURL . '/index.php/api/car');
        $jsonDatacar = $responsecar->json();
        $responsedriver = Http::get('http://' . $currentURL . '/index.php/api/driver');
        $jsonDatadriver = $responsedriver->json();
        return view('admin.booking_request')->with(['booking' => $jsonData, 'car' => $jsonDatacar, 'driver' => $jsonDatadriver]);
    }

    public function booking_user()
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
            ->orderBy('booking_status')
            ->select('car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel', 'driver_fullname', 'car_license', 'tb_booking.*', 'users.username')
            ->get();

        $booking_wait = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->whereIn('tb_booking.username', Auth::user())
            ->orderBy('booking_status')

            ->select('tb_booking.*', 'users.username')
            ->get();
        // return dd($booking);
        //dd($booking);
        $Alllist = DB::table('tb_booking')
            ->whereIn('tb_booking.username', Auth::user())->count();
        $Alllistpending = DB::table('tb_booking')
            ->whereIn('tb_booking.username', Auth::user())->where('booking_status', '=', '1')->count();
        $Alllistapprove = DB::table('tb_booking')
            ->whereIn('tb_booking.username', Auth::user())->where('booking_status', '=', '2')->count();
        $Alllistcancle = DB::table('tb_booking')
            ->whereIn('tb_booking.username', Auth::user())->where('booking_status', '=', '3')->count();
        return view('user.booking')->with(['booking' => $booking, 'booking2' => $booking_wait, 'Alllist' => $Alllist, 'Alllistpending' => $Alllistpending, 'Alllistapprove' => $Alllistapprove, 'Alllistcancle' => $Alllistcancle]);
    }

    public function history()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/booking');
        $his = Http::get('http://' . $currentURL . '/index.php/api/showhistory');
        // $his2 = response()->json($his);
        // dd($his2);
        // dd($response->json());
        $jsonData = $response->json();
        $datahis = $his->json();

        return view('admin.booking_history')->with(['history' => $jsonData, 'hiss' => $datahis]);
    }

    public function showcalendar()
    {
        // $currentURL = request()->getHttpHost();

        // $response = Http::get('http://'.$currentURL.'/index.php/api/calendar');

        // $jsonData = $response->json();
        $bookings = DB::table('tb_booking')
            ->where('booking_status', '!=', '3')
            
            ->get();
        $events = array();
        foreach ($bookings as $booking) {
            $color = null;
            if ($booking->booking_status == '1') {
                $color = 'rgba(245,147,0,0.4)';
            }

            if ($booking->booking_status == '2') {
                $color = 'rgba(0,245,36,0.4)';
            }

            $events[] = [
                'id' => $booking->id,
                'title' => $booking->booking_detail,
                'start' => $booking->booking_start,
                'end' => $booking->booking_end,
                'type' => $booking->type_car,
                'color' => $color,
            ];
        }

        return view('user.dashboard')->with(['booking' => $events]);
    }
    public function cancle($id)
    {

        $canclebooking = BookingModel::find($id);
        $canclebooking->booking_status = ('3');
        $canclebooking->save();
        return redirect()->back()->with('success', 'เรียบร้อย');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $bookingcar = new BookingModel();
        $cnt_booking = $bookingcar->count();

        if ($cnt_booking < 1) {
            $bookingcar->id = 1;
        } else {
            $bookingcar->id = $cnt_booking + 1;
        }
        $bookingcar->username = $request->user_id;
        $bookingcar->booking_start = $request->start;
        $bookingcar->booking_end = $request->end;
        $bookingcar->license_plate = '-';
        $bookingcar->driver = '-';
        $bookingcar->type_car = '-';
        $bookingcar->booking_detail = $request->location;
        $bookingcar->booking_status = '1';
        $bookingcar->save();

        return redirect()->back();
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $id = $request->id_form;

        $booking_update = BookingModel::find($id);


        $booking_update->license_plate = $request->car_id;
        $booking_update->driver = $request->driver_id;
        $booking_update->type_car = $request->type;
        $booking_update->booking_status = "2";

        $booking_update->save();
        return redirect()->back();
    }
    function updateout(Request $request, $id)
    {
        $id = $request->id_form;

        $booking_update = BookingModel::find($id);
        $car_out = new CaroutModel;
        $car_count = DB::table('tb_out_cars')->count();

        if ($car_count < 1) {
            $car_out->id = 1;
            $car_out->car_out_license = $request->car_out_license;
            $car_out->car_out_model = $request->brand +  $request->car_out_model;
            $car_out->driver = $request->car_out_driver;
            $car_out->car_out_tel = $request->car_out_tel;
        } else {
            $car_out->id = $car_count + 1;
            $car_out->car_out_license = $request->car_out_license;
            $car_out->car_out_model = $request->brand +  $request->car_out_model;
            $booking_update->driver = $car_out->car_out_driver;
            $car_out->car_out_tel = $request->car_out_tel;
            $car_out->save();
        }
        $booking_update->license_plate = $request->license_plate;
        $booking_update->driver = $car_out->car_out_driver;
        $booking_update->type_car = $request->type_car;
        $booking_update->booking_status = "2";
        $booking_update->save();
        return redirect()->back();
    }
}
