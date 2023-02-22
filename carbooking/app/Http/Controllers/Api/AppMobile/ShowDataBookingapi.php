<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Api\AppMobile\Bookingapi;
use App\Http\Controllers\backend\Bookingcontroller;
use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\DriverModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowDataBookingapi extends Controller
{
    //
    function showbooking()
    {
        return response()->json([
            'showbooking' => DB::table('tb_booking')-> where('booking_status', 1)->join('users','tb_booking.username','=','users.id')->Orderby('booking_start', 'desc')->get()
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

    public function detail_booking($id)
    {

        $booking = BookingModel::find($id);

        if ($booking->type_car == '1') {
            $detail1 = DB::table('tb_booking')
                ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('tb_cars.car_license as car', 'tb_cars.car_model as car_detail', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'users.name as name_user', 'booking_status', 'type_car')
                ->get();
            $detail2=DB::table('tb_booking')
            ->join('users', 'tb_booking.driver', '=', 'users.id')
            ->where('tb_booking.id', '=', $id)
            ->select('users.name as driver', 'tb_cars.car_license as car', 'tb_cars.car_model as car_detail', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'users.name as name_user', 'booking_status', 'type_car')
            ->get();
        
            $Detail = [
                'car' =>  $detail1->car,
                'car_detail' => $detail1->car_detail,
                'driver' => $detail2->driver,
                'sdate' => $detail1->sdate,
                'edate' => $detail1->edate,
                'booking_detail' => $detail1->booking_detail,
                'name_user' => $detail1->name_user,
                'booking_status' => $detail1->booking_status,
                'type_car' => $detail1->type_car,
               
            ];

        } else if ($booking->type_car == '2') {
            $Detail = DB::table('tb_booking')

                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
                ->where('tb_booking.id', '=', $id)
                ->select('car_out_license as car', 'car_out_model as car_detail', 'car_out_driver as driver', 'car_out_tel as tel', 'owner', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'users.name as name_user', 'booking_status')
                ->get();
        } else {
            $Detail = DB::table('tb_booking')
                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'driver', 'license_plate as car', 'users.name as name_user', 'booking_status', 'type_car')
                ->get();
        }
        return response()->json([
            'detail' => $Detail,
        ]);
    }
    function show_booking($id)
    {


        $booking = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.username',  $id)
            ->orderBy('booking_status')

            ->select('tb_booking.*', 'users.username')
            ->get();

      

        return response()->json([
            'booking' => $booking,
            
        ]);
    }

    function showcar()
    {
        return response()->json(['car' => CarModel::All()]);
    }

    function showdriver()
    {
        return response()->json(['driver' => User::where('role_user','3')->get()]);
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
            $unreserved_driver = DB::table('users')->where('role_user','3')->get();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);
                    });
                })
                ->get();

            $unreserved_driver = DB::table('users')
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);
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
            $unreserved_driver = DB::table('users')->where('role_user','3')->get();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);
                    });
                })
                ->get();

            $unreserved_driver = DB::table('users')
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);
                    });
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);
    }


    public function list_booking()
    {

        $bookingcarin = DB::table('tb_booking') //จำนวนรถภายในคันที่1 ทั้งหมด
        ->select(DB::raw('COUNT(id) suppercarcare'), DB::raw('license_plate'))
        ->where('booking_status', '=', 2)
        ->where('type_car', '=', 1)
        ->groupBy('license_plate')->get();

        return response()->json([
            'allbooking' => DB::table('tb_booking')->count('id'),
            'pending' => DB::table('tb_booking')->where('booking_status', '=', 1)->count('id'),
            'approve' => DB::table('tb_booking')->where('booking_status', '=', 2)->count('id'),
            'cancel' => DB::table('tb_booking')->where('booking_status', '=', 3)->count('id'),
            'car_in' => $bookingcarin
        ]);
    }
}
