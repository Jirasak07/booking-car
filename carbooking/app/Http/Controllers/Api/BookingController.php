<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //
    function index(){
        $booking = DB::table('tb_booking')
        ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
        ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
        ->join('users', 'tb_booking.driver', '=', 'users.id')
        
        ->select( 'car_out_license', 'car_out_model', 'car_out_driver', 'car_out_tel',  'name', 'car_license','tb_booking.*')
        ->get();

        return response()->json($booking);

    }

    function showcalendar(){
        $events =array();
        $bookings = DB::table('tb_booking')
        ->select('id', 'booking_start', 'booking_end', 'type_car')
        ->get();
        foreach($bookings as $item){
            $events[] = [
                'id' => $item->id,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'type' => $item->type_car
            ];
        }
        return response()->json($events);
    }

    function pageupdate(){
        $booking = DB::table('tb_booking')

        ->join('users', 'tb_booking.username', '=', 'users.id')
        ->select( 'tb_booking.*','users.name')
        ->get();

        return response()->json($booking);

    }
    function showhistory(){
        $data = DB::table('tb_booking')
        ->join('users', 'tb_booking.username', '=', 'users.id')
        ->orderBy('tb_booking.updated_at', 'DESC')
        ->select('tb_booking.id','type_car', 'users.name', 'booking_start', 'booking_end', 'booking_status')->get();
        return response()->json($data);
    }


    public function detail_history($id)
    {

        $booking = BookingModel::find($id);

        if ($booking->type_car == '1') {
            $detail1 = DB::table('tb_booking')
           ->join('users','tb_booking.driver','=','users.id')
            ->join('tb_cars','tb_booking.license_plate','=','tb_cars.id')
            ->where('tb_booking.id', '=', $id)
            ->select( 'users.name as driver','car_license','booking_start', 'booking_end', 'booking_detail',  'booking_status', 'type_car')
            ->get();
            $detail2 = DB::table('tb_booking')
            ->join('users','tb_booking.username','=','users.id')
         
             ->where('tb_booking.id', '=', $id)
             ->select( 'users.name as user')
             ->get();


             $row= $detail2[0];
        $item = $detail1[0];
        $Detail[] = [
            'user'=> $row->user,
            'driver'=> $item->driver,
          'car'=> $item->car_license,
            'sdate' => $item->booking_start,
            'edate' => $item->booking_end,
            'booking_detail' => $item->booking_detail,
       
            'booking_status' => $item->booking_status,
            'type_car' => $item->type_car,
           
        ];

        } else if ($booking->type_car == '2') {
            $Detail = DB::table('tb_booking')

                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
                ->where('tb_booking.id', '=', $id)
                ->select('car_out_license as car', 'car_out_model as car_detail', 'car_out_driver as driver', 'car_out_tel as tel', 'owner', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'users.name as name_user','booking_status')
                ->get();
        } else {
            $Detail = DB::table('tb_booking')
                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'driver', 'license_plate as car', 'users.name as name_user','booking_status','type_car')
                ->get();
        }
        return response()->json(
            $Detail
        );

    }
}
