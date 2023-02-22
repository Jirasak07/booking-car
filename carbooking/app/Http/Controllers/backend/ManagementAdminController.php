<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Api\AppMobile\Bookingapi;
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
                $user->status = 0;
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        } else if ($user->role_user == 2) {
            $user->role_user = 3;
            $user->status = 1;
            $user->save();
            return response()->json(['status' => 'success']);
        }else if ($user->role_user == 3) {
            $user->role_user = 1;
            $user->status = 0;
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
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }
 
  

 

    public function caranddriver_edit($id)
    {
        $date = BookingModel::find($id);
        $sdate = $date->booking_start;
        $edate = $date->booking_end;
        $reserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_booking.license_plate')
            ->where('tb_booking.id', '<>', $id)
            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '=', '2')
                        ->orWhere(function ($query) use ($sdate) {
                            $query->Where('tb_booking.booking_end', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $sdate);
                        })
                        ->orWhere(function ($query) use ($sdate, $edate) {
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
            $unreserved_driver = DB::table('users')->where('role_user','3')->where('status',1)->get();
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
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }

   

    function comment(Request $request){
        $id = $request->id_form;
        $comment_booking = BookingModel::find($id);
        $comment_booking->comment = $request->comment;
        $comment_booking->point_booking = $request->star;
        $comment_booking->save();
        return redirect()->back();
    }

    public function noti_aprove($id_booking)
    {
        $id = $id_booking;
        $booking = BookingModel::find($id);
        // $token = "d0SvAc8pAHg:APA91bHyjt1WtXJp2ZsadmR2iJmnKZjtA0R-EjhN4dSK_YCSj8GhqhFlYYDJHnXvVuyE3ixx36mPBI_pBbqE9IVyh-0kdZPVDZXOWqHO66Fnai3DnrXZgldPBdYHJ6Va76Om1KekE-za";
        $token = User::whereNotNull()->where('id',$booking->username)->pluck('token_device')->all();
        $from = "AAAAaxjJHUA:APA91bHLdfsZ_7JfjQEbgDKY49kG21k_OrbGepMG4F-7fq0QN3iaVrS1pXrsyTsmx2ptEvtOGs-lurR8MH_o4RpLUpV5FNCNmrfRQ1504-15_Cg5us3rJ4xA601T9MM842NO7Fz0EUgv";
        $msg = array(
            'body'  => "การจองอนุมัติแล้ว",
            'title' => "BookingCar Lannacom",
            'receiver' => 'erw',
            // 'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            // 'sound' => 'mySound'/*Default sound*/
        );

        $fields = array(
            'to'        => $token,
            'notification'  => $msg
        );

        $headers = array(
            'Authorization: key=' . $from,
            'Content-Type: application/json'
        );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    
    }

}
