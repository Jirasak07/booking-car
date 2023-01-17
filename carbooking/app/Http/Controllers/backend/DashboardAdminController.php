<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function PHPSTORM_META\type;

class DashboardAdminController extends Controller
{
    //
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
            ->select(DB::raw('COUNT(id) suppercarcare'))
            ->where('type_car', '=', 1)
            ->groupBy('license_plate')->count();

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
            ->where('booking_status',2)
            ->where('type_car',1)
            ->get();
        $data2 = DB::table('tb_booking') //จำนวนการจองแยกตามเดือน ปี ทั้งหมด
            ->select(DB::raw('COUNT(id) data'), DB::raw('YEAR(booking_start) year, MONTH(booking_start) month'))
            ->groupByraw('YEAR(booking_start)')
            ->groupByraw('MONTH(booking_start)')
            ->where('booking_status',2)
            ->where('type_car',2)
            ->get();
        $allcar1 = DB::table('tb_booking')->select(DB::raw('COUNT(id) allcar1'))->where('booking_status',2)->where('type_car',1)->get();
        $allcar2 = DB::table('tb_booking')->select(DB::raw('COUNT(id) allcar2'))->where('booking_status',2)->where('type_car',2)->get();
        $car = CarModel::All();
        $allbooking = BookingModel::count();
        $pending = BookingModel::where('booking_status', 1)->count();
        $approve = BookingModel::where('booking_status', 2)->count();
        $cancel = BookingModel::where('booking_status', 3)->count();
        //return view('admin.dashboard')->with(['car' => $car,'allbook'=>$allbooking,'pending'=>$pending ,'approve'=>$approve ,'cancel'=>$cancel]);

        // $data = BookingModel::all()->Groupby("MONTH(booking_start)")->count('id');
        //    return dd($data);

        return view('admin.dashboard')->with(['data2' => $data2,'data1' => $data1,'allcar1'=>$allcar1,'allcar2'=>$allcar2, 'bookingcarAllin' => $bookingcarAllin, 'bookingcarAllout' => $bookingcarAllout, 'car' => $car, 'allbook' => $allbooking, 'pending' => $pending, 'approve' => $approve, 'cancel' => $cancel,'bookingcarin'=>$bookingcarin ])

        ;
    }

}
