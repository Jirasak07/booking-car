<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function autocancle(){
        $current_date_time = Carbon::now();
        DB::table('tb_booking')
            ->where('booking_status', '1')
            ->where('booking_start', '<', Carbon::now()->subMinutes(15))
            ->update(['booking_status'=>'3','booking_detail'=>'booking_detail'.'~'.'หมดเวลาการจองแล้ว']);
    }

    public function autobooking(){
        $current_date_time = Carbon::now();
        DB::table('tb_booking')
            ->where('booking_status', '2')
            ->where('booking_start', '<', Carbon::now())
            ->update(['booking_status'=>'4']);
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // //
        $this->autocancle();
    }
}
