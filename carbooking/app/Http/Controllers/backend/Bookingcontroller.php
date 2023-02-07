<?php

namespace App\Http\Controllers\backend;


use App\Http\Controllers\Controller;
use App\Models\BookingModel;

use App\Models\timebookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use DateTime;


class Bookingcontroller extends Controller
{
    //
    public function index()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/pageupdate');
        $jsonData = $response->json();
        $responsecar = Http::get('http://' . $currentURL . '/index.php/api/car');
        $jsonDatacar = $responsecar->json();
        $responsedriver = Http::get('http://' . $currentURL . '/index.php/api/driver');
        $jsonDatadriver = $responsedriver->json();
        return view('admin.booking_request')->with(['booking' => $jsonData, 'car' => $jsonDatacar, 'driver' => $jsonDatadriver]);
    }
    public function requestDataTable()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/pageupdate');
        $jsonData = $response->json();
        $responsecar = Http::get('http://' . $currentURL . '/index.php/api/car');
        $jsonDatacar = $responsecar->json();
        $responsedriver = Http::get('http://' . $currentURL . '/index.php/api/driver');
        $jsonDatadriver = $responsedriver->json();
        return response()->json(['data' => $jsonData]);
    }

    public function history()
    {
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://' . $currentURL . '/index.php/api/booking');
        $his = Http::get('http://' . $currentURL . '/index.php/api/showhistory');

        $jsonData = $response->json();
        $datahis = $his->json();

        return view('admin.booking_history')->with(['history' => $jsonData, 'hiss' => $datahis]);
    }

    public function showcalendar()
    {

        $datenow = new DateTime();
        $format_date = $datenow->format('Y-m-d H:i:s');
        $bookings = DB::table('tb_booking')
            ->where('booking_status', '!=', '3')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('tb_booking.*')
            ->get();
        $events = array();

        foreach ($bookings as $booking) {
            $color = null;
            if ($booking->booking_status == '1') {
                $color = '#ffd166';
                $events[] = [
                    'id' => $booking->id,
                    'title' => $booking->booking_detail,
                    'start' => $booking->booking_start,
                    'end' => $booking->booking_end,
                    'color' => $color,
                    'type' => '1',
                    'description' => '-'
                ];
            }
        }
        $booking_join1 = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->where('tb_booking.type_car', '=', '1')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)

            ->select('driver_fullname', 'car_license', 'car_model', 'tb_booking.*')
            ->get();
        foreach ($booking_join1 as $item) {
            $color = '#06d6a0';
            $car = "รถภายใน";
            $events[] = [
                'id' => $item->id,
                'title' => $item->booking_detail,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'color' => $color,
                'type' => '2',
                'description' => $car . ' ทะเบียนรถ ' .  ' ' . $item->car_license . ' คนขับรถ ' . $item->driver_fullname,
            ];
        }
        $booking_join2 = DB::table('tb_booking')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
            ->where('tb_booking.type_car', '=', '2')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel', 'tb_booking.*')
            ->get();
        $car = "รถภายนอก";
        foreach ($booking_join2 as $item2) {
            $color = '#06d6a0';
            $car = "รถภายนอก";
            $events[] = [
                'id' => $item2->id,
                'title' => $item2->booking_detail,
                'start' => $item2->booking_start,
                'end' => $item2->booking_end,
                'color' => $color,
                'type' => '2',
                'description' => $car . ' ทะเบียนรถ ' .  ' ' . $item2->car_out_license . ' คนขับรถ ' . $item2->car_out_driver . ' เบอร์โทร ' . $item2->car_out_tel,
            ];
        }

        return view('user.dashboard')->with(['booking' => $events]);
    }

    public function refresh_calendar()
    {
        $datenow = new DateTime();
        $format_date = $datenow->format('Y-m-d H:i:s');
        $bookings = DB::table('tb_booking')
            ->where('booking_status', '!=', '3')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('tb_booking.*')
            ->get();
        $events = array();

        foreach ($bookings as $booking) {
            $color = null;
            if ($booking->booking_status == '1') {
                $color = '#ffd166';
                $events[] = [
                    'id' => $booking->id,
                    'title' => $booking->booking_detail,
                    'start' => $booking->booking_start,
                    'end' => $booking->booking_end,
                    'color' => $color,
                    'type' => '1',
                    'description' => '-'
                ];
            }
        }
        $booking_join1 = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->where('tb_booking.type_car', '=', '1')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)

            ->select('driver_fullname', 'car_license', 'car_model', 'tb_booking.*')
            ->get();
        foreach ($booking_join1 as $item) {
            $color = '#06d6a0';
            $car = "รถภายใน";
            $events[] = [
                'id' => $item->id,
                'title' => $item->booking_detail,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'color' => $color,
                'type' => '2',
                'description' => $car . ' ทะเบียนรถ ' .  ' ' . $item->car_license . ' คนขับรถ ' . $item->driver_fullname,
            ];
        }
        $booking_join2 = DB::table('tb_booking')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
            ->where('tb_booking.type_car', '=', '2')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel', 'tb_booking.*')
            ->get();
        $car = "รถภายนอก";
        foreach ($booking_join2 as $item2) {
            $color = '#06d6a0';
            $car = "รถภายนอก";
            $events[] = [
                'id' => $item2->id,
                'title' => $item2->booking_detail,
                'start' => $item2->booking_start,
                'end' => $item2->booking_end,
                'color' => $color,
                'type' => '2',
                'description' => $car . ' ทะเบียนรถ ' .  ' ' . $item2->car_out_license . ' คนขับรถ ' . $item2->car_out_driver . ' เบอร์โทร ' . $item2->car_out_tel,
            ];
        }


        return response()->json($events);
    }
    public function cancle($id, $note)
    {
        $canclebooking = BookingModel::find($id);
        $canclebooking->driver = '-';
        $canclebooking->license_plate = '-';
        $canclebooking->type_car = '-';
        $canclebooking->booking_status = ('3');
        $canclebooking->booking_detail =  $canclebooking->booking_detail . "~" . $note;
        $canclebooking->save();
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

        $bookingcar->save();

        return redirect()->back()->with('success', 'การจองสำเร็จ');
    }
    function edit_booking(Request $request)
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

    function validate_booking()
    {

        return response()->json([
            'timeafter' => timebookingModel::find(1),
            'timebefore' => timebookingModel::find(2),
            'timemin' => timebookingModel::find(3),
            'timemax' => timebookingModel::find(4),
        ]);
    }
}
