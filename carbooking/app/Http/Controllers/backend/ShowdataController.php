<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\CarModel;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ShowdataController extends Controller
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
    public function history()
    {
        $currentURL = request()->getHttpHost();
        
        $his = Http::get('http://' . $currentURL . '/index.php/api/showhistory');

       
        $datahis = $his->json();

        return view('admin.booking_history')->with(['hiss' => $datahis]);
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
                    'description' => '-',
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
            $color = '#06d6a0';
            $car = "รถภายใน";
            $events[] = [
                'id' => $item->id,
                'title' => $item->booking_detail,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'color' => $color,
                'type' => '2',
                'description' => $car . ' ทะเบียนรถ ' . ' ' . $item->car_license . ' คนขับรถ ' . $item->name,
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
                'description' => $car . ' ทะเบียนรถ ' . ' ' . $item2->car_out_license . ' คนขับรถ ' . $item2->car_out_driver . ' เบอร์โทร ' . $item2->car_out_tel,
            ];
        }

        return view('user.dashboard')->with(['booking' => $events]);
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
                    'description' => '-',
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
            $color = '#06d6a0';
            $car = "รถภายใน";
            $events[] = [
                'id' => $item->id,
                'title' => $item->booking_detail,
                'start' => $item->booking_start,
                'end' => $item->booking_end,
                'color' => $color,
                'type' => '2',
                'description' => $car . ' ทะเบียนรถ ' . ' ' . $item->car_license . ' คนขับรถ ' . $item->name,
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
                'description' => $car . ' ทะเบียนรถ ' . ' ' . $item2->car_out_license . ' คนขับรถ ' . $item2->car_out_driver . ' เบอร์โทร ' . $item2->car_out_tel,
            ];
        }

        return response()->json($events);
    }

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



    public function index2()
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
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.type_car', '=', '1')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('car_license', 'car_model', 'tb_booking.*','name')
            ->get();

            $driver =DB::table('tb_booking')
    
            ->join('users', 'tb_booking.driver', '=', 'users.id')
            ->where('tb_booking.type_car', '=', '1')
            ->where('tb_booking.booking_status', '!=', '3')
            ->where('tb_booking.booking_status', '!=', '1')
            ->where('tb_booking.booking_end', '>', $format_date)
            ->select('name',  'tb_booking.*')
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
                'titlee'=> ' รถภายใน : '. $item->car_model.'  ทะเบียน : '.$item->car_license.' พนักงานขับ : '//---

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
                ->select('car_out_license as car', 'car_out_model as car_detail', 'car_out_driver as driver', 'car_out_tel as tel', 'owner', 'booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'users.name as user','booking_status')
                ->get();
        } else {
            $Detail = DB::table('tb_booking')
                ->join('users', 'tb_booking.username', '=', 'users.id')
                ->where('tb_booking.id', '=', $id)
                ->select('booking_start as sdate', 'booking_end as edate', 'booking_detail', 'type_car', 'driver', 'license_plate as car', 'users.name as name_user','booking_status','type_car')
                ->get();
        }
        return response()->json([
            'detail' => $Detail,
        ]);

    }
    function show_booking()
    {
  

        $booking_wait = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.username', '=', Auth::user()->id)
            ->ORDERBY('comment', 'ASC')
            ->ORDERBY('booking_status', 'desc')
            ->select('tb_booking.*', 'users.username')
            ->get();

        $Alllist = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->count();
        $Alllistpending = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '1')->count();
        $Alllistapprove = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '2')->count();
        $Alllistcancle = DB::table('tb_booking')
            ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '3')->count();
       
        return view('user.booking')->with([/* 'booking' => $booking, */'booking2' => $booking_wait, 'Alllist' => $Alllist, 'Alllistpending' => $Alllistpending, 'Alllistapprove' => $Alllistapprove, 'Alllistcancle' => $Alllistcancle]);
    }
    function detail_booking($id)
    {
        $booking = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.id', '=', $id)
            ->select('tb_booking.*', 'users.name')
            ->get();
        foreach ($booking as $value) {
            if ($value->booking_status == '2') {
                if ($value->type_car == '1') {
                    $car = DB::table('tb_booking')
                        ->join('tb_cars', 'tb_booking.license_plate', '=', 'tb_cars.id')
                        ->join('users', 'tb_booking.driver', '=', 'users.id')
                        ->select('name as name_driver', 'car_license as car_license', 'car_model as car_model', 'tb_booking.*')
                        ->where('tb_booking.id', '=', $id)
                        ->get();
                } elseif ($value->type_car == '2') {
                    $car = DB::table('tb_booking')
                        ->join('tb_out_cars', 'tb_booking.license_plate', '=', 'tb_out_cars.id')
                        ->select('car_out_license as car_license', 'car_out_model as car_model', 'car_out_driver as name_driver', 'car_out_tel', 'tb_booking.*')
                        ->where('tb_booking.id', '=', $id)
                        ->get();
                }
                foreach ($car as $key) {
                    $data = [
                        'id' => $value->id,
                        'name' => $value->name,
                        'booking_start' => $value->booking_start,
                        'booking_end' => $value->booking_end,
                        'booking_detail' => $value->booking_detail,
                        'booking_status' => $value->booking_status,
                        'name_driver' => $key->name_driver,
                        'car_license' => $key->car_license,
                        'car_model' => $key->car_model
                    ];
                }
            } else {
                $data = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'booking_start' => $value->booking_start,
                    'booking_end' => $value->booking_end,
                    'booking_detail' => $value->booking_detail,
                    'booking_status' => $value->booking_status,
                    'name_driver' => '-',
                    'car_license' => '-',
                    'car_model' => '-'
                ];
            }
        }
        return response()->json($data);
    }

    public function refresh_booking()
    {
        $booking2 = DB::table('tb_booking')
            ->join('users', 'tb_booking.username', '=', 'users.id')
            ->where('tb_booking.username', '=', Auth::user()->id)
            ->orderBy('booking_status')
            ->select('tb_booking.*', 'users.username')
            ->get();

        foreach ($booking2 as $value2) {
            $res[] = [
                'id' => $value2->id,
                'booking_detail' => $value2->booking_detail,
                'booking_end' => $value2->booking_end,
                'booking_start' => $value2->booking_start,
                'booking_status' => $value2->booking_status,
                'driver' => $value2->driver,
                'license_plate' => $value2->license_plate,
                'type_car' => $value2->type_car,
                'username' => $value2->username,
            ];
        }

        return response()->json([
            'res'=>$res,
            'Alllist' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->count(),
            'Alllistpending' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '1')->count(),
            'Alllistapprove' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '2')->count(),
            'Alllistcancle' => DB::table('tb_booking')
                ->where('tb_booking.username', '=', Auth::user()->id)->where('booking_status', '=', '3')->count(),
        ]);
    }
    public function show_user()
    {
        $user = User::all();

        return view('admin.manage_user', ['user' => $user]);
    }

    function show_driver(){
        $currentURL = request()->getHttpHost();
        $response = Http::get('http://'.$currentURL.'/index.php/api/driver');


      $jsonData = $response->json();
        return view('admin.manage_driver')->with(['driver' => $jsonData]);
    }
    function show_car(){
        $currentURL = request()->getHttpHost();
      $response = Http::get('http://'.$currentURL.'/index.php/api/car');

      $jsonData = $response->json();
        return view('admin.manage_car')->with(['car' => $jsonData]);
    }


    public function caranddriver_aprove($id)
    {
        $date = BookingModel::find($id);
        $sdate = $date->booking_start;
        $edate = $date->booking_end;
        $reserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_booking.license_plate')

            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '==', '2')
                        ->orWhere(function ($query) use ($sdate) {
                            $query->Where('tb_booking.booking_end', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $sdate);

                        })  ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->where('tb_booking.booking_start', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $edate);
                        })->orWhere(function ($query) use ($edate) {
                        $query->where('tb_booking.booking_start', '>', $edate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '>', $sdate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '<', $sdate)
                            ->Where('tb_booking.booking_end', '>', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '=', $sdate)
                            ->Where('tb_booking.booking_end', '=', $edate);
                    })
                    ;
                })
                ;
            })
            ->select('tb_booking.license_plate', 'tb_booking.driver')
            ->orderBy('tb_booking.booking_start')
            ->get();
        $car = array();
        foreach ($reserved_cars as $item) {
            $car[] = [
                'id' => $item->license_plate,
            ];

        }
        $driver = array();
        foreach ($reserved_cars as $item) {
            $driver[] = [
                'id' => $item->driver,
            ];

        }

        $count = BookingModel::where('booking_status', '2')->where('type_car', '1')->count();
        if ($count < 1) {
            $unreserved_cars = CarModel::all();
            $unreserved_driver = DB::table('users')->where('role_user',3)->where('status',1)->get();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);

                    })
                    ;
                })
                ->get();

            $unreserved_driver = DB::table('users')
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }
 
  

 

    public function caranddriver_edit($id)
    {
        $date = BookingModel::find($id);
        $sdate = $date->booking_start;
        $edate = $date->booking_end;
        $reserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_booking.license_plate')
            ->where('tb_booking.id', '<>', $id)
            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '=', '2')
                        ->orWhere(function ($query) use ($sdate) {
                            $query->Where('tb_booking.booking_end', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $sdate);
                        })
                        ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->where('tb_booking.booking_start', '>', $sdate)
                                ->Where('tb_booking.booking_start', '<', $edate);
                        })->orWhere(function ($query) use ($edate) {
                        $query->where('tb_booking.booking_start', '>', $edate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '>', $sdate)
                            ->Where('tb_booking.booking_end', '<', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '<', $sdate)
                            ->Where('tb_booking.booking_end', '>', $edate);
                    })->orWhere(function ($query) use ($sdate, $edate) {
                        $query->where('tb_booking.booking_start', '=', $sdate)
                            ->Where('tb_booking.booking_end', '=', $edate);
                    })
                    ;
                })
                ;
            })
            ->select('tb_booking.license_plate', 'tb_booking.driver')
            ->orderBy('tb_booking.booking_start')
            ->get();
        $car = array();
        foreach ($reserved_cars as $item) {
            $car[] = [
                'id' => $item->license_plate,
            ];

        }
        $driver = array();
        foreach ($reserved_cars as $item) {
            $driver[] = [
                'id' => $item->driver,
            ];

        }

        $count = BookingModel::where('booking_status', '2')->where('type_car', '1')->count();
        if ($count < 1) {
            $unreserved_cars = CarModel::all();
            $unreserved_driver = DB::table('users')->where('role_user','3')->where('status',1)->get();
        } else {
            $unreserved_cars = DB::table('tb_cars')
                ->where('car_status', '1')
                ->where(function ($query) use ($car) {
                    $query->where(function ($query) use ($car) {
                        $query->Where('tb_cars.id', '!=', $car);

                    })
                    ;
                })
                ->get();

            $unreserved_driver = DB::table('users')
                ->where('status', '1')
                ->where(function ($query) use ($driver) {
                    $query->where(function ($query) use ($driver) {
                        $query->Where('users.id', '!=', $driver);

                    })
                    ;
                })
                ->get();
        }

        return response()->json(['car' => $unreserved_cars, 'driver' => $unreserved_driver]);

    }

    function noti_menu(){
        $cnt_booking = BookingModel::where('booking_status',1)->count();
        return response()->json(['booking' => $cnt_booking ]);
    }

}
