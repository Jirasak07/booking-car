<?php

namespace App\Http\Controllers\Api\AppMobile;

use App\Http\Controllers\Controller;
use App\Mail\CalcleEmailComponent;
use App\Mail\SendEmailComponent;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\CaroutModel;
use App\Models\DriverModel;
use App\Models\timebookingModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Bookingapi extends Controller
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
            'booking_detail.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',

        ]);
        $date_start = Carbon::parse($validatedData['booking_start'])->format('Y-m-d\TH:i:s');
        $date_end = Carbon::parse($validatedData['booking_end'])->format('Y-m-d\TH:i:s');

       

        $bookingcar = new BookingModel();
        $cnt_booking = DB::table('tb_booking')->count();
     
        if ($cnt_booking < 1) {
            $bookingcar->id = 1;
        } else {
            $bookingcar->id = $cnt_booking + 1;
        }
        $bookingcar->username = $request->user_id;
        $bookingcar->booking_start = $date_start;
        $bookingcar->booking_end = $date_end;
        $bookingcar->license_plate = '-';
        $bookingcar->driver = '-';
        $bookingcar->type_car = '-';
        $bookingcar->booking_detail = $validatedData['booking_detail'];
        $bookingcar->booking_status = '1';
 
        $bookingcar->save();
        return response()->json( $bookingcar->id,201);
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
            'booking_detail' => 'required',
        ], [
            'booking_start.after' => 'โปรดจองก่อนเดินทาง ' . $timeafter->time . ' ' . $timeafter->unit_th . '',
            'booking_start.before' => 'โปรดจองล่วงหน้าก่อนเดินทางได้ไม่เกิน ' . $timebefore->time . ' ' . $timebefore->unit_th . '',
            'booking_end.after' => 'โปรดระบุเวลาการเดินทางอย่างน้อย ' . $timemin->time . ' ' . $timemin->unit_th . '',
            'booking_end.before' => 'โปรดระบุเวลาการเดินทางได้ไม่เกิน ' . $timemax->time . ' ' . $timemax->unit_th . '',
            'booking_detail.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',

        ]);
        $id = $request->id;
        $date_start = Carbon::parse($varlidate['booking_start'])->format('Y-m-d\TH:i:s');
        $date_end = Carbon::parse($varlidate['booking_end'])->format('Y-m-d\TH:i:s');
        $booking = BookingModel::find($id);
        $booking->booking_start = $date_start;
        $booking->booking_end = $date_end;
        $booking->booking_detail = $varlidate['booking_detail'];
        $booking->save();


     

        return response()->json(['booking' => $booking], 201);
    }

   
   
    public function edit_bookingin(Request $request)
    {
        $id = $request->id;
        $booking_edit = BookingModel::find($id);
        $booking_edit->license_plate = $request->car_id;
        $booking_edit->driver = $request->driver_id;
        $booking_edit->save();
    }

    

    
public function cancle($id,Request $request)
{
    $canclebooking = BookingModel::find($id);
    $canclebooking->driver = '-';
    $canclebooking->license_plate = '-';
    $canclebooking->type_car = '-';
    $canclebooking->booking_status = ('3');
    $canclebooking->booking_detail = $canclebooking->booking_detail . "~" . $request->reason;
    $canclebooking->save();


  
    $data = [
        'title' => 'BookingCar(การจองรถ)',
        'detail' =>  'การจองรายการนี้ได้ถูกยกเลิกไปแล้ว',
       

    ];
    Mail::to('wirunsak2003@gmail.com')->send(new CalcleEmailComponent($data));


    return response()->json(201);
}

public function Validates(){
    return response()->json([
        'timeafter' => timebookingModel::find(1),
        'timebefore' => timebookingModel::find(2),
        'timemin' => timebookingModel::find(3),
        'timemax' => timebookingModel::find(4),
    ]);
}
}
