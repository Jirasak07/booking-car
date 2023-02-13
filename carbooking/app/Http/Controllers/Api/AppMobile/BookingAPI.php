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
            'location.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',

        ]);
        $booking = new BookingModel();
        $cnt_booking = $booking->count();
        
        if ($cnt_booking < 1) {
            $booking->id = 1;
        } else {
            $booking->id = $cnt_booking + 1;
        }
        $booking->username = $request->input('user_id');
        $booking->license_plate = '-';
        $booking->driver = '-';
        $booking->type_car = '-';
        $booking->booking_start = $validatedData['booking_start'];
        $booking->booking_end = $validatedData['booking_end'];
        $booking->booking_detail = $validatedData['booking_detail'];
        $booking->booking_status = 1;
        $booking_new=BookingModel::create($booking);
    
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


     

        return response()->json(['booking' => $booking], 201);
    }

   
   
    public function edit_bookingin(Request $request)
    {
        $id = $request->id_form;
        $booking_edit = BookingModel::find($id);
        $booking_edit->license_plate = $request->license;
        $booking_edit->driver = $request->driver;
        $booking_edit->save();
    }

    

    
public function cancle($id, $note)
{
    $canclebooking = BookingModel::find($id);
    $canclebooking->driver = '-';
    $canclebooking->license_plate = '-';
    $canclebooking->type_car = '-';
    $canclebooking->booking_status = ('3');
    $canclebooking->booking_detail = $canclebooking->booking_detail . "~" . $note;
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
