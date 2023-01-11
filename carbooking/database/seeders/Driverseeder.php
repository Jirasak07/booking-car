<?php

namespace Database\Seeders;

use App\Models\DriverModel;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class Driverseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            ['id' => '1',
                'driver_fullname' => 'มาโนช วันชนะ',
                'driver_status'    => '1'
          
            ],
            ['id' => '2',
                'driver_fullname' => 'มานะ วันชโนช',
                'driver_status'    => '1'
         
            ],    ['id' => '3',
                'driver_fullname' => 'มานพ สบภัย',
                'driver_status'    => '1'
          
            ],   ['id' => '4',
                'driver_fullname' => 'มานิด พิชิตแสง',
                'driver_status'    => '1'
          
            ]
          
        ];
        foreach($user as $key => $value){
             DriverModel::create($value);
        }
        //
        //
    }
}


