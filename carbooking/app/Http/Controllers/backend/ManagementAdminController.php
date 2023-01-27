<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CaroutModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
        $unreserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_booking.license_plate')

            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '<>', '2')
                        ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->Where('tb_booking.booking_end', '>' ,$sdate )
                            ->Where('tb_booking.booking_start', '<', $sdate );

                        }) ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->where('tb_booking.booking_start', '<', $edate )
                            ->Where('tb_booking.booking_end', '>', $edate);
                        });
                })
                    ->orWhereNull('tb_booking.license_plate');
            })->orderBy('tb_booking.booking_start')
            ->get();
        $unreserved_driver = DB::table('tb_driver')
            ->leftJoin('tb_booking', 'tb_driver.id', '=', 'tb_booking.driver')

            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '=', '2')
                    ->orWhere(function ($query) use ($sdate, $edate) {
                        $query->Where('tb_booking.booking_end', '>' ,$sdate )
                        ->Where('tb_booking.booking_start', '<', $sdate );

                    }) ->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '<', $edate )
                        ->Where('tb_booking.booking_end', '>', $edate);
                    });
                })
                    ->orWhereNull('tb_booking.driver');
            })
            ->get();
           dd($sdate,$edate,$unreserved_cars);

            // return response()->json(['unreserved_cars' => $unreserved_cars, 'unreserved_driver' => $unreserved_driver]);

        // return (['unreserved_cars' => $unreserved_cars, 'unreserved_driver' => $unreserved_driver]);
    }
    public function aprove_in(Request $request)
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
    public function aprove_out(Request $request)
    {


        $request->validate(
            [
                'car_out_license' => 'required|min:3',
                'brand' => 'required|min:3',
                'car_out_model' => 'required|min:10',
                'owner' => 'required|min:10',
                'car_out_driver' => 'required|min:10',
                'car_out_tel' => 'required|numeric|digits_between:8,15',
            ],
            [
                'car_out_license.required' => 'โปรดระบุทะเบียน',
                'brand.required' => 'โปรดระบุยี่ห้อรถ',
                'car_out_model.required' => 'โปรดระบุรายละเอียดรุ่นรถ',
                'owner.required' => 'โปรดระบุชื่อเจ้าของรถ',
                'car_out_driver.required' => 'โปรดระบุชื่อคนขับ',
                'car_out_tel.required' => 'โปรดระบุเบอร์โทรเจ้าของรถ',
                // 'email.email' => 'รูปแบบอีเมล์ไม่ถูกต้อง',
                'car_out_tel.numeric' => 'ระบุเฉพาะตัวเลขเท่านั้น',
                'car_out_tel.digits_between' => 'เบอร์โทรต้องมี 8 - 15 ตัว',
            ]
        );

        $id = $request->id_form;

        $booking_update = BookingModel::find($id);
        $car_out = new CaroutModel();
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
            $booking_update->driver =  $request->car_out_driver;
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
            $booking_update->driver =  $request->car_out_driver;
            $booking_update->type_car = "2";
            $booking_update->booking_status = "2";
            $booking_update->save();
        }

        return redirect()->back();
    }

    public function edit_booking(Request $request){
        $id = $request->id_form;
        $booking_edit  = BookingModel::find($id);
        $booking_edit->license_plate = $request->license;
        $booking_edit->driver = $request->driver;
        $booking_edit->save();
    }
}
