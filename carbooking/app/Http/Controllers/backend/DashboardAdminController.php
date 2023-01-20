<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
    public function index()
    {

        $date = Carbon::now()->format('d-m-Y H:i:s');
        // // dd($date);
        $bookingcar1ad = DB::table('tb_booking') //จำนวนรถภายในคันที่1 ที่อนุมัติแล้ว
            ->where('license_plate', '=', 1)
            ->where('type_car', '=', 1)
            ->where('booking_status', '=', 2)->count();

        $bookingcar2ad = DB::table('tb_booking') //จำนวนรถภายในคันที่2 ที่อนุมัติแล้ว
            ->where('license_plate', '=', 2)
            ->where('type_car', '=', 1)
            ->where('booking_status', '=', 2)->count();

        $bookingcar1wil = DB::table('tb_booking') //จำนวนรถภายในคันที่1 ที่รอดำเนินการ
            ->where('license_plate', '=', 1)
            ->where('type_car', '=', 1)
            ->where('booking_status', '=', 1)->count();

        $bookingcar2wil = DB::table('tb_booking') //จำนวนรถภายในคันที่2 ที่รอดำเนินการ
            ->where('license_plate', '=', 2)
            ->where('type_car', '=', 1)->count();

        $bookingcar1can = DB::table('tb_booking') //จำนวนรถภายในคันที่1 ที่ไม่อนุมัติ
            ->where('license_plate', '=', 1)
            ->where('type_car', '=', 1)
            ->where('booking_status', '=', 3)->count();

        $bookingcar2can = DB::table('tb_booking') //จำนวนรถภายในคันที่2 ที่ไม่อนุมัติ
            ->where('license_plate', '=', 2)
            ->where('type_car', '=', 1)
            ->where('booking_status', '=', 3)->count();

        $bookingcarin = DB::table('tb_booking') //จำนวนรถภายในคันที่1 ทั้งหมด
            ->select(DB::raw('COUNT(id) suppercarcare'), DB::raw('license_plate'))
            ->where('booking_status', '=', 2)
            ->where('type_car', '=', 1)

            ->groupBy('license_plate')->get();
        // dd($bookingcarin);
        $bookingcar2 = DB::table('tb_booking') //จำนวนรถภายในคันที่2 ทั้งหมด
            ->where('license_plate', '=', 2)
            ->where('type_car', '=', 1)->count();

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
        //return view('admin.dashboard')->with(['car' => $car,'allbook'=>$allbooking,'pending'=>$pending ,'approve'=>$approve ,'cancel'=>$cancel]);

        // $data = BookingModel::all()->Groupby("MONTH(booking_start)")->count('id');
        //  return dd($bookingcarin);
        return view('admin.dashboard')->with(['data2' => $data2, 'data1' => $data1, 'allcar1' => $allcar1, 'allcar2' => $allcar2, 'bookingcarAllin' => $bookingcarAllin, 'bookingcarAllout' => $bookingcarAllout, 'car' => $car, 'allbook' => $allbooking, 'pending' => $pending, 'approve' => $approve, 'cancel' => $cancel, 'bookingcarin' => $bookingcarin])

        ;
    }

    function detail_history($id){

        $booking = BookingModel::find($id);

        if($booking->type_car == '1'){
            $detail = DB::table('tb_booking')
            ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')

            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->join('tb_driver', 'tb_booking.driver', '=', 'tb_driver.id')
            ->where('tb_booking.id','=', $id)
            ->select('tb_driver.driver_fullname as driver', 'tb_cars.car_license as car','tb_cars.car_model as car_detail','booking_start as sdate','booking_end as edate','booking_detail','users.name as name_user')
            ->get();
        }else if($booking->type_car == 2){
            $detail = DB::table('tb_booking')

            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
            ->where('tb_booking.id','=', $id)
            ->select('car_out_license as car', 'car_out_model car_detail', 'car_out_driver as driver', 'car_out_tel as tel','owner','booking_start as sdate','booking_end as edate','booking_detail','type_car','users.name as name_user')
            ->get();
        }else{
            $detail = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.id','=', $id)
            ->select('booking_start as sdate','booking_end as edate','booking_detail','type_car','driver','license_plate as car','users.name as name_user')
            ->get();
        }

        return response()->json([
            'detail' =>$detail
        ]);

    }

}
