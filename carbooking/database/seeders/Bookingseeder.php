<?php

namespace Database\Seeders;

use App\Models\BookingModel;
use Illuminate\Database\Seeder;

class Bookingseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            [
                'booking_start' => '2023-01-15 03:20:24',
                'booking_end'    => '2023-01-15 05:20:24',
                'license_plate' => '1',
                'username'    => '2',
                'driver' => '2',
                'type_car'    => '1',
                'booking_detail' => 'ขนของไป เชียงใหม่.',
                'booking_status'    => '2'
          
            ],
            [
                'booking_start' => '2023-01-15 03:20:24',
                'booking_end'    => '2023-01-16 05:20:24',
                'license_plate' => '1',
                'username'    => '2',
                'driver' => '1',
                'type_car'    => '2',
                'booking_detail' => 'ขนของไป กทม.',
                'booking_status'    => '2'
          
            ],
            [
                'booking_start' => '2023-01-18 03:20:24',
                'booking_end'    => '2023-01-20 07:20:24',
                'license_plate' => '2',
                'username'    => '1',
                'driver' => '2',
                'type_car'    => '1',
                'booking_detail' => 'ขนของไป เชียงใหม่.',
                'booking_status'    => '2'
          
            ],
          
        ];
        foreach($user as $key => $value){
             BookingModel::create($value);
        }
    }
}
