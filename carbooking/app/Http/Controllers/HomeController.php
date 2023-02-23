<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\User;
use DateTime;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function caranddriver_aprove($id)
    {
        $date = BookingModel::find($id);
        $sdate = $date->booking_start;
        $edate = $date->booking_end;
        $reserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_booking.license_plate')

            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '==', '2')
                        ->orWhere(function ($query) use ($sdate) {
                            $query->Where('tb_booking.booking_end', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $sdate);
                        })  ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->where('tb_booking.booking_start', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $edate);
                        })->orWhere(function ($query) use ($edate) {
                        $query->where('tb_booking.booking_start', '>', $edate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '>', $sdate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '<', $sdate)
                            ->Where('tb_booking.booking_end', '>', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '=', $sdate)
                            ->Where('tb_booking.booking_end', '=', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '=', $sdate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '=', $sdate)
                            ->Where('tb_booking.booking_end', '>', $edate);
                    })
                    ->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '<', $sdate)
                            ->Where('tb_booking.booking_end', '=', $edate);
                    })
                    ->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '>', $sdate)
                            ->Where('tb_booking.booking_end', '=', $edate);
                    })
                    ;
                })
                ;
            })
            ->select('tb_booking.license_plate', 'tb_booking.driver')
            ->orderBy('tb_booking.booking_start')
            ->get();
        $car = array();
        foreach ($reserved_cars as $item) {
            $car[] = [
                'id' => $item->license_plate,
            ];

        }
       
        $driver = array();
        foreach ($reserved_cars as $item) {
            $driver[] = [
                'id' => $item->driver,
            ];

        }
       
        $count = BookingModel::where('booking_status', '2')->where('type_car', '1')->count();
        if ($count < 1) {
            $unreserved_cars = CarModel::all();
            $unreserved_driver = DB::table('users')->where('role_user',3)->where('status',1)->get();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);

                    })
                    ;
                })
                ->get();

            $unreserved_driver = DB::table('users')
            ->where('role_user',3)
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }
        dd($unreserved_driver);
        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }
}
