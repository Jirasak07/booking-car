<?php

namespace App\Http\Controllers\backend;

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
    public function index()
    {
        $user = User::all();

        return view('admin.manage_user', ['user' => $user]);
    }

    public function edit_role($id)
    {
        $findSumAdmin = User::where('role_user', 1)->sum('id');

        $user = User::find($id);
        if ($user->role_user == 1) {
            if ($findSumAdmin > 1) {
                $user->role_user = 2;
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        } else if ($user->role_user == 2) {
            $user->role_user = 1;
            $user->save();
            return response()->json(['status' => 'success']);
        }
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
            $unreserved_driver = DriverModel::all();
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

            $unreserved_driver = DB::table('tb_driver')
                ->where('driver_status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('tb_driver.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }
    public function aprove_in(Request $request)
    {

        $id = $request->id_form;
        $booking_update = BookingModel::find($id);
        if ($booking_update->booking_status == 1) {
            $booking_update->license_plate = $request->car_id;
            $booking_update->driver = $request->driver_id;
            $booking_update->type_car = $request->type;
            $booking_update->booking_status = "2";
            $booking_update->save();

            // $data = [ 'title' => 'BookingCar(การจองรถ)',];

            // Mail::to('merlinxi.5409@gmail.com')->send(new SendEmailComponent($data));
            return redirect()->back()->with('idf', $id);
        } else {
            return redirect()->back()->with('success', "รายการนี้ถูกยกเลิกไปแล้ว");
        }

    }
    public function aprove_out(Request $request)
    {
        $id = $request->id_form;
        $booking_update = BookingModel::find($id);
        $car_out = new CaroutModel();

        if ($booking_update->booking_status == 1) {
            $car_lic = DB::table('tb_out_cars')->where('car_out_license', '=', $request->car_out_license)
                ->where('car_out_driver', '=', $request->car_out_driver)->select('id')->get();

            $car = array();
            foreach ($car_lic as $item) {
                $car[] = [
                    'id' => $item->id,

                ];
            }
            $cars_id = implode(', ', array_column($car, 'id'));

            $car_all = DB::table('tb_out_cars')->where('car_out_license', '=', $request->car_out_license)
                ->where('car_out_driver', '=', $request->car_out_driver)->select('car_out_license')->get();
            $cars = array();
            foreach ($car_all as $item) {
                $cars[] = [
                    'license' => $item->car_out_license,
                ];
            }
            $cars_string = implode(', ', array_column($cars, 'license'));

            $driver_all = DB::table('tb_out_cars')->where('car_out_license', '=', $request->car_out_license)
                ->where('car_out_driver', '=', $request->car_out_driver)->select('car_out_driver')->get();
            $driver = array();
            foreach ($driver_all as $item) {
                $driver[] = [
                    'driver' => $item->car_out_driver,
                ];
            }
            $driver_string = implode(', ', array_column($driver, 'driver'));
            $car_count = DB::table('tb_out_cars')->count();

            if ($car_count < 1) {
                $car_out->id = 1;
                $car_out->car_out_license = $request->car_out_license;
                $car_out->car_out_model = $request->brand . " " . $request->car_out_model;
                $car_out->owner = $request->owner;
                $car_out->car_out_driver = $request->car_out_driver;
                $car_out->car_out_tel = $request->car_out_tel;
                $car_out->save();
                $booking_update->license_plate = 1;
                $booking_update->driver = $request->car_out_driver;
                $booking_update->type_car = "2";
                $booking_update->booking_status = "2";
                $booking_update->save();
            } else if ($request->car_out_license == $cars_string and $request->car_out_driver == $driver_string) {
                $booking_update->license_plate = $cars_id;
                $booking_update->driver = $request->car_out_driver;
                $booking_update->type_car = "2";
                $booking_update->booking_status = "2";
                $booking_update->save();

            } else {
                $car_out->id = $car_count + 1;
                $car_out->car_out_license = $request->car_out_license;
                $car_out->car_out_model = $request->brand . " " . $request->car_out_model;
                $car_out->owner = $request->owner;
                $car_out->car_out_driver = $request->car_out_driver;
                $car_out->car_out_tel = $request->car_out_tel;
                $car_out->save();
                $booking_update->license_plate = $car_count + 1;
                $booking_update->driver = $request->car_out_driver;
                $booking_update->type_car = "2";
                $booking_update->booking_status = "2";
                $booking_update->save();

            }
            // $booking = DB::table('tb_booking')->where('id',$id)->join('users', 'tb_booking.username', '=', 'users.id')->select('email','username')->get();

            $data = [
                'title' => 'BookingCar(การจองรถ)',
                'license' => $request->car_out_license,
                'car' => $request->brand . " " . $request->car_out_model,
                'driver' => $request->car_out_driver,
                'sdate' => $booking_update->booking_start,
                'edate' => $booking_update->booking_end,
                'detail' => $booking_update->booking_detail,
            ];

            // // $user = [
            // //     'email' =>  $booking['username'],
            // // ];

            Mail::to('merlinxi.5409@gmail.com')->send(new SendEmailComponent($data));

            return redirect()->back();

        } else {
            $booking_update->booking_status = $booking_update->booking_status;
            $booking_update->save();
            return redirect()->back()->with('success', "รายการนี้ถูกยกเลิกไปแล้ว");
        }

    }

    public function edit_booking(Request $request)
    {
        $id = $request->id_form;
        $booking_edit = BookingModel::find($id);
        $booking_edit->license_plate = $request->license;
        $booking_edit->driver = $request->driver;
        $booking_edit->save();
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
            $unreserved_driver = DriverModel::all();
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

            $unreserved_driver = DB::table('tb_driver')
                ->where('driver_status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('tb_driver.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }

    public function sendmail($id)
    {

        $booking = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->select(  'driver_fullname', 'car_license', 'tb_booking.*')
            ->where('tb_booking.id',$id)
            ->get();
        $data2 = $booking[0];
        $data = [
            'license' => $data2->driver_fullname,
        ];
        Mail::to('merlinxi.5409@gmail.com')->send(new SendEmailComponent($data));

        return response()->json($data2->driver_fullname);
    }

}
