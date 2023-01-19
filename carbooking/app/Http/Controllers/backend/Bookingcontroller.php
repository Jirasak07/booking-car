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
use Illuminate\Support\Carbon;

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
            ->select('tb_booking.*')
            ->get();
        $events = array();
        foreach ($bookings as $booking) {
            $color = null;
            
            if ($booking->type_car == '1') {
                $car = "รถภายใน";
            } elseif ($booking->type_car == '2') {
                $car = "รถภายนอก";
            }
            if ($booking->booking_status == '1') {
                $color = 'rgba(245,147,0,0.4)';
                $events[] = [
                    'id' => $booking->id,
                    'title' => $booking->booking_detail,
                    'start' => $booking->booking_start,
                    'end' => $booking->booking_end,
                    'color' => $color,
                ];
            }

            if ($booking->booking_status == '2') {
                $color = 'rgba(0,245,36,0.4)';
                $events[] = [
                    'id' => $booking->id,
                    'title' => $booking->booking_detail . '(' . $car.')',
                    'start' => $booking->booking_start,
                    'end' => $booking->booking_end,
                    'color' => $color,
                ];
            }
        }

        return view('user.dashboard')->with(['booking' => $events]);
    }
    public function cancle($id)
    {

        $canclebooking = BookingModel::find($id);
        $canclebooking->booking_status = ('3');
        $canclebooking->save();
        return response()->json(['status'=>'success']);
    }
    public function store(Request $request)
    {
        $date_start = Carbon::parse($request->date_start)->format('Y-m-d\TH:i:s');
        $date_end = Carbon::parse($request->date_end)->format('Y-m-d\TH:i:s');
        //dd($request->all(),$date_start,$date_end);
        $bookingcar = new BookingModel();
        $cnt_booking = $bookingcar->count();

        if ($cnt_booking < 1) {
            $bookingcar->id = 1;
        } else {
            $bookingcar->id = $cnt_booking + 1;
        }
        $bookingcar->username = $request->user_id;
        $bookingcar->booking_start = $date_start;
        $bookingcar->booking_end = $date_end;
        $bookingcar->license_plate = '-';
        $bookingcar->driver = '-';
        $bookingcar->type_car = '-';
        $bookingcar->booking_detail = $request->location;
        $bookingcar->booking_status = '1';
        $bookingcar->save();

        return redirect()->back()->with('success', 'การจองสำเร็จ');
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
