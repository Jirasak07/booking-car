<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\BookingModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManagementAdminController extends Controller
{
    //
    public function index()
    {
        $user = User::all();

        return view('admin.manage_user', ['user' => $user]);
    }

    public function edit_role($id)
    {
        $findSumAdmin = User::where('role_user', 1)->sum('id');

        $user = User::find($id);
        if ($user->role_user == 1) {
            if ($findSumAdmin > 1) {
                $user->role_user = 2;
                $user->save();
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error']);
            }
        } else if ($user->role_user == 2) {
            $user->role_user = 1;
            $user->save();
            return response()->json(['status' => 'success']);
        }
    }
    public function caranddriver_aprove($id)
    {
        $date = BookingModel::find($id);
        $sdate = $date->booking_start;
        $edate = $date->booking_end;
        $unreserved_cars = DB::table('tb_cars')
            ->leftJoin('tb_booking', 'tb_cars.id', '=', 'tb_bookings.license_plate')
            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '<>', '2')
                        ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->where('tb_booking.booking_start', '>', $edate)
                                ->orWhere('tb_booking.booking_end', '<', $sdate);
                        });
                })
                    ->orWhereNull('tb_booking.license_plate');
            })
            ->get();
        $unreserved_driver = DB::table('tb_driver')
            ->leftJoin('tb_booking', 'tb_driver.id', '=', 'tb_bookings.driver')
            ->where(function ($query) use ($sdate, $edate) {
                $query->where(function ($query) use ($sdate, $edate) {
                    $query->where('tb_booking.booking_status', '<>', '2')
                        ->orWhere(function ($query) use ($sdate, $edate) {
                            $query->where('tb_booking.booking_start', '>', $edate)
                                ->orWhere('tb_booking.booking_end', '<', $sdate);
                        });
                })
                    ->orWhereNull('tb_booking.driver');
            })
            ->get();

        return view('admin.booking_request', ['unreserved_cars' => $unreserved_cars, 'unreserved_driver' => $unreserved_driver]);
    }
}
