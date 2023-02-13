<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Api\AppMobile\Bookingapi;
use App\Http\Controllers\backend\Bookingcontroller;
use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\DriverModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowDataBookingapi extends Controller
{
    //
    function showbooking()
    {
        return response()->json([
            'showbooking' => BookingModel::where('booking_status', 1)->all()
        ]);
    }

    function showhistory()
    {
        $data = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->orderBy('tb_booking.updated_at', 'DESC')
            ->select('tb_booking.id', 'type_car', 'users.name', 'booking_start', 'booking_end', 'booking_status')->get();
        return response()->json($data);
    }

    public function detail_history($id)
    {

        $booking = BookingModel::find($id);

        if ($booking->type_car == '1') {
            $detail = DB::table('tb_booking')
                ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')

                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
                ->where('tb_booking.id', '=', $id)
                ->select('tb_driver.driver_fullname as driver', 'tb_cars.car_license as car', 'tb_cars.car_model as car_detail', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'users.name as name_user', 'booking_status', 'type_car')
                ->get();
        } else if ($booking->type_car == '2') {
            $detail = DB::table('tb_booking')

                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
                ->where('tb_booking.id', '=', $id)
                ->select('car_out_license as car', 'car_out_model as car_detail', 'car_out_driver as driver', 'car_out_tel as tel', 'owner', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'users.name as name_user', 'booking_status')
                ->get();
        } else {
            $detail = DB::table('tb_booking')
                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'driver', 'license_plate as car', 'users.name as name_user', 'booking_status', 'type_car')
                ->get();
        }
        return response()->json([
            'detail' => $detail,
        ]);
    }
    function show_booking()
    {


        $booking = DB::table('tb_booking')
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

        return response()->json([
            'booking' => $booking,
            'Alllist' => $Alllist,
            'Alllistpending' => $Alllistpending,
            'Alllistapprove' => $Alllistapprove,
            'Alllistcancle' => $Alllistcancle
        ]);
    }

    function showcar()
    {
        return response()->json(['car' => CarModel::All()]);
    }

    function showdriver()
    {
        return response()->json(['driver' => DriverModel::All()]);
    }

    public function caranddriver_edit($id)
    {
        $date = BookingModel::find($id);
        $sdate = $date->booking_start;
        $edate = $date->booking_end;
        $reserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_booking.license_plate')
            ->where('tb_booking.id', '!=', $id)
            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '==', '2')
                        ->orWhere(function ($query) use ($sdate) {
                            $query->Where('tb_booking.booking_end', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $sdate);
                        })->orWhere(function ($query) use ($sdate, $edate) {
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
                        });
                });
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
            $unreserved_driver = DriverModel::all();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);
                    });
                })
                ->get();

            $unreserved_driver = DB::table('tb_driver')
                ->where('driver_status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('tb_driver.id', '!=', $driver);
                    });
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);
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
                        })->orWhere(function ($query) use ($sdate, $edate) {
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
                        });
                });
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
            $unreserved_driver = DriverModel::all();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);
                    });
                })
                ->get();

            $unreserved_driver = DB::table('tb_driver')
                ->where('driver_status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('tb_driver.id', '!=', $driver);
                    });
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);
    }
}
