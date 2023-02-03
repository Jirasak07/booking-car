<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserBookingController extends Controller
{
    //


    function show_booking()
    {
  

        $booking_wait = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.username', '=', Auth::user()->id)
            ->orderBy('booking_status')

            ->select('tb_booking.*', 'users.username')
            ->get();

        $Alllist = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->count();
        $Alllistpending = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '1')->count();
        $Alllistapprove = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '2')->count();
        $Alllistcancle = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '3')->count();
       
        return view('user.booking')->with([/* 'booking' => $booking, */'booking2' => $booking_wait, 'Alllist' => $Alllist, 'Alllistpending' => $Alllistpending, 'Alllistapprove' => $Alllistapprove, 'Alllistcancle' => $Alllistcancle]);
    }
    function detail_booking($id)
    {
        $booking = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.id', '=', $id)
            ->select('tb_booking.*', 'users.name')
            ->get();
        foreach ($booking as $value) {
            if ($value->booking_status == '2') {
                if ($value->type_car == '1') {
                    $car = DB::table('tb_booking')
                        ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
                        ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
                        ->select('driver_fullname as name_driver', 'car_license as car_license', 'car_model as car_model', 'tb_booking.*')
                        ->where('tb_booking.id', '=', $id)
                        ->get();
                } elseif ($value->type_car == '2') {
                    $car = DB::table('tb_booking')
                        ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
                        ->select('car_out_license as car_license', 'car_out_model as car_model', 'car_out_driver as name_driver', 'car_out_tel', 'tb_booking.*')
                        ->where('tb_booking.id', '=', $id)
                        ->get();
                }
                foreach ($car as $key) {
                    $data = [
                        'id' => $value->id,
                        'name' => $value->name,
                        'booking_start' => $value->booking_start,
                        'booking_end' => $value->booking_end,
                        'booking_detail' => $value->booking_detail,
                        'booking_status' => $value->booking_status,
                        'name_driver' => $key->name_driver,
                        'car_license' => $key->car_license,
                        'car_model' => $key->car_model
                    ];
                }
            } else {
                $data = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'booking_start' => $value->booking_start,
                    'booking_end' => $value->booking_end,
                    'booking_detail' => $value->booking_detail,
                    'booking_status' => $value->booking_status,
                    'name_driver' => '-',
                    'car_license' => '-',
                    'car_model' => '-'
                ];
            }
        }
        return response()->json($data);
    }

    public function refresh_booking()
    {
        $booking2 = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.username', '=', Auth::user()->id)
            ->orderBy('booking_status')
            ->select('tb_booking.*', 'users.username')
            ->get();

        foreach ($booking2 as $value2) {
            $res[] = [
                'id' => $value2->id,
                'booking_detail' => $value2->booking_detail,
                'booking_end' => $value2->booking_end,
                'booking_start' => $value2->booking_start,
                'booking_status' => $value2->booking_status,
                'driver' => $value2->driver,
                'license_plate' => $value2->license_plate,
                'type_car' => $value2->type_car,
                'username' => $value2->username,
            ];
        }

        return response()->json([
            'res'=>$res,
            'Alllist' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->count(),
            'Alllistpending' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '1')->count(),
            'Alllistapprove' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '2')->count(),
            'Alllistcancle' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '3')->count(),
        ]);
    }
}
