<?php

namespace App\Http\Controllers\backend;

use App\Events\StoreNotification;
use App\Http\Controllers\Controller;
use App\Mail\CalcleEmailComponent;
use App\Mail\EmailComponent;
use App\Models\BookingModel;
use App\Models\timebookingModel;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Bookingcontroller extends Controller
{
    //
   
   
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
    

        return response()->json(['status' => 'success']);
    }
    public function store(Request $request)
    {
        $timeafter = timebookingModel::find(1);
        $timebefore = timebookingModel::find(2);
        $timemin = timebookingModel::find(3);
        $timemax = timebookingModel::find(4);
        $varlidate = $request->validate([
            'date_start' => 'required|date|after:now + ' . $timeafter->time . ' ' . $timeafter->unit . '|before:now + ' . $timebefore->time . ' ' . $timebefore->unit . '',
            'date_end' => 'required|date|after: ' . $request->date_start . ' + ' . $timemin->time . ' ' . $timemin->unit . '|before:' . $request->date_start . ' + ' . $timemax->time . ' ' . $timemax->unit . '',
            'location' => 'required',
        ], [
            'date_start.after' => 'โปรดจองก่อนเดินทาง ' . $timeafter->time . ' ' . $timeafter->unit_th . '',
            'date_start.before' => 'โปรดจองล่วงหน้าก่อนเดินทางได้ไม่เกิน ' . $timebefore->time . ' ' . $timebefore->unit_th . '',
            'date_end.after' => 'โปรดระบุเวลาการเดินทางอย่างน้อย ' . $timemin->time . ' ' . $timemin->unit_th . '',
            'date_end.before' => 'โปรดระบุเวลาการเดินทางได้ไม่เกิน ' . $timemax->time . ' ' . $timemax->unit_th . '',
            'location.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',

        ]);

        $date_start = Carbon::parse($request->date_start)->format('Y-m-d\TH:i:s');
        $date_end = Carbon::parse($request->date_end)->format('Y-m-d\TH:i:s');

        $bookingcar = new BookingModel();
        $cnt_booking = $bookingcar->count();
        $id_form = $cnt_booking + 1;
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
        $bookingcar->booking_detail = $request->location;
        $bookingcar->booking_status = '1';
        // dd($bookingcar->id);
        $bookingcar->save();

        return response()->json(['id_form' => $id_form]);

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

        return redirect()->back()->with('success_edit', 'complete');
    }

    public function validate_booking()
    {

        return response()->json([
            'timeafter' => timebookingModel::find(1),
            'timebefore' => timebookingModel::find(2),
            'timemin' => timebookingModel::find(3),
            'timemax' => timebookingModel::find(4),
        ]);
    }
   
   
}
