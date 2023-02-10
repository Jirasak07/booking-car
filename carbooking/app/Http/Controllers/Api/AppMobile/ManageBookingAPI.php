<?php

namespace App\Http\Controllers\Api\AppMobile\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailComponent;
use App\Models\BookingModel;
use App\Models\CaroutModel;
use App\Models\timebookingModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ManageBookingAPI extends Controller
{
    //

    function bookingcar(Request $request){
        $timeafter = timebookingModel::find(1);
        $timebefore = timebookingModel::find(2);
        $timemin = timebookingModel::find(3);
        $timemax = timebookingModel::find(4);
        $validatedData = $request->validate([
            'booking_start' => 'required|date|after:now + ' . $timeafter->time . ' ' . $timeafter->unit . '|before:now + ' . $timebefore->time . ' ' . $timebefore->unit . '',
            'booking_end' => 'required|date|after: ' . $request->date_start . ' + ' . $timemin->time . ' ' . $timemin->unit . '|before:' . $request->date_start . ' + ' . $timemax->time . ' ' . $timemax->unit . '',
            'booking_detail' => 'required',
    
        ]
    
        , [
            'date_start.after' => 'โปรดจองก่อนเดินทาง ' . $timeafter->time . ' ' . $timeafter->unit_th . '',
            'date_start.before' => 'โปรดจองล่วงหน้าก่อนเดินทางได้ไม่เกิน ' . $timebefore->time . ' ' . $timebefore->unit_th . '',
            'date_end.after' => 'โปรดระบุเวลาการเดินทางอย่างน้อย ' . $timemin->time . ' ' . $timemin->unit_th . '',
            'date_end.before' => 'โปรดระบุเวลาการเดินทางได้ไม่เกิน ' . $timemax->time . ' ' . $timemax->unit_th . '',
            'location.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',

        ]);
        $booking = new BookingModel();
        $cnt_booking = $booking->count();
     
        if ($cnt_booking < 1) {
            $booking->id = 1;
        } else {
            $booking->id = $cnt_booking + 1;
        }
        $booking->username = $request->user_id;
        $booking->license_plate = '-';
        $booking->driver = '-';
        $booking->type_car = '-';
        $booking->booking_start = $validatedData['booking_start'];
        $booking->booking_end = $validatedData['booking_end'];
        $booking->booking_detail = $validatedData['booking_detail'];
        $booking->booking_status = 1;
        $booking->save();
    
        return response()->json(['booking' => $booking], 201);
    }


    public function edit_booking(Request $request)
    {
        $timeafter = timebookingModel::find(1);
        $timebefore = timebookingModel::find(2);
        $timemin = timebookingModel::find(3);
        $timemax = timebookingModel::find(4);
        $varlidate = $request->validate([
            'booking_start' => 'required|date|after:now + ' . $timeafter->time . ' ' . $timeafter->unit . '|before:now + ' . $timebefore->time . ' ' . $timebefore->unit . '',
            'booking_end' => 'required|date|after: ' . $request->booking_start . ' + ' . $timemin->time . ' ' . $timemin->unit . '|before:' . $request->booking_start . ' + ' . $timemax->time . ' ' . $timemax->unit . '',
        ], [
            'booking_start.after' => 'โปรดจองก่อนเดินทาง ' . $timeafter->time . ' ' . $timeafter->unit_th . '',
            'booking_start.before' => 'โปรดจองล่วงหน้าก่อนเดินทางได้ไม่เกิน ' . $timebefore->time . ' ' . $timebefore->unit_th . '',
            'booking_end.after' => 'โปรดระบุเวลาการเดินทางอย่างน้อย ' . $timemin->time . ' ' . $timemin->unit_th . '',
            'booking_end.before' => 'โปรดระบุเวลาการเดินทางได้ไม่เกิน ' . $timemax->time . ' ' . $timemax->unit_th . '',
            'location.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',

        ]);
        $id = $request->id;
        $date_start = Carbon::parse($request->booking_start)->format('Y-m-d\TH:i:s');
        $date_end = Carbon::parse($request->booking_end)->format('Y-m-d\TH:i:s');
        $booking = BookingModel::find($id);
        $booking->booking_start = $date_start;
        $booking->booking_end = $date_end;
        $booking->booking_detail = $request->booking_detail;
        $booking->save();


        // Mail::send('emails.booking_confirmation', ['booking' => $booking], function ($message) use ($validatedData) {
        //     $message->to($validatedData['email'])->subject('Booking Confirmation');
        // });

        return response()->json(['booking' => $booking], 201);
    }

    function Aprove_in(Request $request){
        $id = $request->id_form;
        $booking_update = BookingModel::find($id);
        if ($booking_update->booking_status == 1) {
            $booking_update->license_plate = $request->car_id;
            $booking_update->driver = $request->driver_id;
            $booking_update->type_car = $request->type;
            $booking_update->booking_status = "2";
            $booking_update->save();


            return response()->json(['$booking_update'=> $ $booking_update,'id_in' =>$id_form],201);
        } else {
            return  response()->json('รายการนี้ถูกยกเลิกไปแล้ว');
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


            return response()->json([' $car_out'=> $ $car_out,'booking_update' => $booking_update,'id_out' =>$id],201);

        } else {
          
            return response()->json('รายการนี้ถูกยกเลิกไปแล้ว');
        }

    }
    function sendEmail($id_out){
        $booking = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->select('driver_fullname', 'car_license', 'tb_booking.booking_detail as detail',
            'tb_booking.booking_start as sdate','tb_booking.booking_end as edate','car_model','users.name as name')
            ->where('tb_booking.id', $id_out)
            ->get();
        $item= $booking[0];
        $data = [
            'license' => $item->car_license,
            'name'=> $item->name,
            'driver' => $item->driver_fullname,
            'car'=> $item->car_model,
            'detail'=> $item->detail,
            'sdate'=> $item->sdate,
            'edate'=> $item->edate,
        ];
        Mail::to('wirunsak2003@gmail.com')->send(new SendEmailComponent($data));

        return response()->json( $data,201);
    }

    public function sendmailout($id_in)
    {

        $booking = DB::table('tb_booking')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')

            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->select('car_out_driver', 'car_out_license', 'tb_booking.booking_detail as detail',
            'tb_booking.booking_start as sdate','tb_booking.booking_end as edate','car_out_model','users.name as name')
            ->where('tb_booking.id', $id_in)
            ->get();
        $item= $booking[0];
        $data = [
            'license' => $item->car_out_license,
            'name'=> $item->name,
            'driver' => $item->car_out_driver,
            'car'=> $item->car_out_model,
            'detail'=> $item->detail,
            'sdate'=> $item->sdate,
            'edate'=> $item->edate,
        ];
        Mail::to('wirunsak2003@gmail.com')->send(new SendEmailComponent($data));

        return response()->json($data,201);
    }
}
