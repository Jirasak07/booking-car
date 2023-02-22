<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CaroutModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Aproveapi extends Controller
{
    //

    function Aprove_in(Request $request){
        $id = $request->id_form;
        $booking_aprove = BookingModel::find($id);
        if ($booking_aprove->booking_status == 1) {
            $booking_aprove->license_plate = $request->car_id;
            $booking_aprove->driver = $request->driver_id;
            $booking_aprove->type_car = $request->type;
            $booking_aprove->booking_status = "2";
            $booking_aprove->save();


            return response()->json(201);
        } else {
            return  response()->json('รายการนี้ถูกยกเลิกไปแล้ว');
        }

    }

    public function Aprove_out(Request $request)
    {
        $id = $request->id;
        $booking_update = BookingModel::find($id);
        $car_out = new CaroutModel();

        if ($booking_update->booking_status == 1) {
            $car_lic = DB::table('tb_out_cars')->where('car_out_license', '=', $request->license)
                ->where('car_out_driver', '=', $request->driver)->select('id')->get();

            $car = array();
            foreach ($car_lic as $item) {
                $car[] = [
                    'id' => $item->id,

                ];
            }
            $cars_id = implode(', ', array_column($car, 'id'));

            $car_all = DB::table('tb_out_cars')->where('car_out_license', '=', $request->license)
                ->where('car_out_driver', '=', $request->driver)->select('car_out_license')->get();
            $cars = array();
            foreach ($car_all as $item) {
                $cars[] = [
                    'license' => $item->license,
                ];
            }
            $cars_string = implode(', ', array_column($cars, 'license'));

            $driver_all = DB::table('tb_out_cars')->where('car_out_license', '=', $request->license)
                ->where('car_out_driver', '=', $request->driver)->select('car_out_driver')->get();
            $driver = array();
            foreach ($driver_all as $item) {
                $driver[] = [
                    'driver' => $item->driver,
                ];
            }
            $driver_string = implode(', ', array_column($driver, 'driver'));
            $car_count = DB::table('tb_out_cars')->count();

            if ($car_count < 1) {
                $car_out->id = 1;
                $car_out->car_out_license = $request->license;
                $car_out->car_out_model = $request->brand . " " . $request->model;
                $car_out->owner = $request->owner;
                $car_out->car_out_driver = $request->driver;
                $car_out->car_out_tel = $request->tel;
                $car_out->save();
                $booking_update->license_plate = 1;
                $booking_update->driver = $request->driver;
                $booking_update->type_car = "2";
                $booking_update->booking_status = "2";
                $booking_update->save();
            } else if ($request->license == $cars_string and $request->driver == $driver_string) {
                $booking_update->license_plate = $cars_id;
                $booking_update->driver = $request->driver;
                $booking_update->type_car = "2";
                $booking_update->booking_status = "2";
                $booking_update->save();

            } else {
                $car_out->id = $car_count + 1;
                $car_out->car_out_license = $request->license;
                $car_out->car_out_model = $request->brand . " " . $request->model;
                $car_out->owner = $request->owner;
                $car_out->car_out_driver = $request->driver;
                $car_out->car_out_tel = $request->tel;
                $car_out->save();
                $booking_update->license_plate = $car_count + 1;
                $booking_update->driver = $request->driver;
                $booking_update->type_car = "2";
                $booking_update->booking_status = "2";
                $booking_update->save();

            }


            return response()->json(201);

        } else {
          
            return response()->json('error',400);
        }

    }
}
