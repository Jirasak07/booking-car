<?php

namespace App\Http\Controllers\backend;

use App\Events\StoreNotification;
use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;

use DateTime;

use Illuminate\Support\Facades\DB;




class DashboardAdminController extends Controller
{
    //
    public function refresh()
    {

        return response()->json([
            'allbooking' => DB::table('tb_booking')->count('id'),
            'pending' => DB::table('tb_booking')->where('booking_status', '=', 1)->count('id'),
            'approve' => DB::table('tb_booking')->where('booking_status', '=', 2)->count('id'),
            'cancel' => DB::table('tb_booking')->where('booking_status', '=', 3)->count('id'),
        ]);
    }



    public function eventcalen()
    {
        $datenow = new DateTime();
        $format_date = $datenow->format('Y-m-d H:i:s');
        $bookings = DB::table('tb_booking')
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
                    'color' => '#ffd166',

                ];
            }
        }

        $booking_join1 = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('users', 'tb_booking.driver', '=', 'users.id')
            ->where('tb_booking.type_car', '=', '1')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)

            ->select('name', 'car_license', 'car_model', 'tb_booking.*')
            ->get();
        foreach ($booking_join1 as $item) {
            $color = '#06d6a0 ';
            $events[] = [
                'id' => $item->id,
                'title' => $item->booking_detail,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'color' => '#06d6a0 ',

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
        $carevents = "รถภายนอก";
        foreach ($booking_join2 as $item2) {
            $color = 'rgba(0,245,36,0.4)';
            $carevents = "รถภายใน";
            $events[] = [
                'id' => $item2->id,
                'title' => $item2->booking_detail,
                'start' => $item2->booking_start,
                'end' => $item2->booking_end,
                'color' => '#06d6a0 ',

            ];
        }
        return response()->json($events);
    }



    public function index()
    {
        $datenow = new DateTime();
        $format_date = $datenow->format('Y-m-d H:i:s');



        $bookingcarin = DB::table('tb_booking') //จำนวนรถภายในคันที่1 ทั้งหมด
            ->select(DB::raw('COUNT(id) suppercarcare'), DB::raw('license_plate'))
            ->where('booking_status', '=', 2)
            ->where('type_car', '=', 1)

            ->groupBy('license_plate')->get();



        $bookingcarAllin = DB::table('tb_booking') //จำนวนรถภายใน ทั้งหมด
            ->where('type_car', '=', 1)->count();

        $bookingcarAllout = DB::table('tb_booking') //จำนวนรถภายนอก ทั้งหมด
            ->where('type_car', '=', 2)->count();

        $data1 = DB::table('tb_booking') //จำนวนการจองแยกตามเดือน ปี ทั้งหมด
            ->select(DB::raw('COUNT(id) data'), DB::raw('YEAR(booking_start) year, MONTH(booking_start) month'))
            ->groupByraw('YEAR(booking_start)')
            ->groupByraw('MONTH(booking_start)')
            ->where('booking_status', 2)
            ->where('type_car', 1)
            ->get();
        $data2 = DB::table('tb_booking') //จำนวนการจองแยกตามเดือน ปี ทั้งหมด
            ->select(DB::raw('COUNT(id) data'), DB::raw('YEAR(booking_start) year, MONTH(booking_start) month'))
            ->groupByraw('YEAR(booking_start)')
            ->groupByraw('MONTH(booking_start)')
            ->where('booking_status', 2)
            ->where('type_car', 2)
            ->get();
        $allcar1 = DB::table('tb_booking')->select(DB::raw('COUNT(id) allcar1'))->where('booking_status', 2)->where('type_car', 1)->get();
        $allcar2 = DB::table('tb_booking')->select(DB::raw('COUNT(id) allcar2'))->where('booking_status', 2)->where('type_car', 2)->get();
        $car = CarModel::All();
        $allbooking = DB::table('tb_booking')->count('id');
        $pending = DB::table('tb_booking')->where('booking_status', '=', 1)->count('id');
        $approve = DB::table('tb_booking')->where('booking_status', '=', 2)->count('id');
        $cancel = DB::table('tb_booking')->where('booking_status', '=', 3)->count('id');


        $bookings = DB::table('tb_booking')
        ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('tb_booking.*','name')
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
                    'color' => '#ffd166',
                    'data'=>$booking->name,
                    'type'=>'1',
                    'titlee'=>'-'

                ];
            }
        }

        $booking_join1 = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
            ->join('users', 'tb_booking.driver', '=', 'users.id')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.type_car', '=', '1')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)

            ->select('name', 'car_license', 'car_model', 'tb_booking.*','name')
            ->get();
        foreach ($booking_join1 as $item) {
            $color = '#06d6a0 ';
            $events[] = [
                'id' => $item->id,
                'title' => $item->booking_detail,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'color' => '#06d6a0 ',
                'data'=>$item->name,
                'type'=>'2',
                'titlee'=> ' รถภายใน : '. $item->car_model.'  ทะเบียน : '.$item->car_license.' พนักงานขับ : '.$item->name

            ];
        }
        $booking_join2 = DB::table('tb_booking')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.type_car', '=', '2')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel', 'tb_booking.*','name')
            ->get();
        $carevents = "รถภายนอก";
        foreach ($booking_join2 as $item2) {
            $color = 'rgba(0,245,36,0.4)';
            $carevents = "รถภายใน";
            $events[] = [
                'id' => $item2->id,
                'title' => $item2->booking_detail,
                'start' => $item2->booking_start,
                'end' => $item2->booking_end,
                'color' => '#06d6a0 ',
                'data'=>$item2->name,
                'type'=>'2',
                'titlee'=>' รถภายนอก : '.$item2->car_out_model.' ทะเบียน : '.$item2->car_out_license .' เบอร์โทรติดต่อ : '.$item2->car_out_tel ,

            ];
        }
        return view('admin.dashboard')->with(['calenbook' => $events, 'data2' => $data2, 'data1' => $data1, 'allcar1' => $allcar1, 'allcar2' => $allcar2, 'bookingcarAllin' => $bookingcarAllin, 'bookingcarAllout' => $bookingcarAllout, 'car' => $car, 'allbook' => $allbooking, 'pending' => $pending, 'approve' => $approve, 'cancel' => $cancel, 'bookingcarin' => $bookingcarin])

        ;
    }



    public function detail_history($id)
    {

        $booking = BookingModel::find($id);

        if ($booking->type_car == '1') {
            $detail = DB::table('tb_booking')
                ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')

                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->join('users', 'tb_booking.driver', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('users.name as driver', 'tb_cars.car_license as car', 'tb_cars.car_model as car_detail', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'users.name as name_user','booking_status','type_car')
                ->get();
        } else if ($booking->type_car == '2') {
            $detail = DB::table('tb_booking')

                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
                ->where('tb_booking.id', '=', $id)
                ->select('car_out_license as car', 'car_out_model as car_detail', 'car_out_driver as driver', 'car_out_tel as tel', 'owner', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'users.name as name_user','booking_status')
                ->get();
        } else {
            $detail = DB::table('tb_booking')
                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'driver', 'license_plate as car', 'users.name as name_user','booking_status','type_car')
                ->get();
        }
        return response()->json([
            'detail' => $detail,
        ]);

    }

function noti_menu(){
    $cnt_booking = BookingModel::where('booking_status',1)->count();
    return response()->json(['booking' => $cnt_booking ]);
}



}
