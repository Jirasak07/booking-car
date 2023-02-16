<?php

namespace App\Http\Controllers\api\AppMobile;

use App\Http\Controllers\Controller;
use App\Mail\EmailComponent;
use App\Mail\SendEmailComponent;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Emailapi extends Controller
{
    //

    function sendEmail($id){
        $booking = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->select('driver_fullname', 'car_license', 'tb_booking.booking_detail as detail',
            'tb_booking.booking_start as sdate','tb_booking.booking_end as edate','car_model','users.name as name')
            ->where('tb_booking.id', $id)
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

        return response()->json($data,201);
    }

    public function sendmailout($id)
    {

        $booking = DB::table('tb_booking')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')

            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->select('car_out_driver', 'car_out_license', 'tb_booking.booking_detail as detail',
            'tb_booking.booking_start as sdate','tb_booking.booking_end as edate','car_out_model','users.name as name')
            ->where('tb_booking.id', $id)
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

    public function mailbooking($id)
    {
        $booking = BookingModel::find($id);
        $item = $booking;
        $data = [
            'title' => 'BookingCar(การจองรถ)',
            'sdate' => $item->booking_start,
            'edate' => $item->booking_end,
            'detail' => $item->booking_detail,

        ];
        Mail::to('wirunsak2003@gmail.com')->send(new EmailComponent($data));
        return response()->json('Success');
    }
}
