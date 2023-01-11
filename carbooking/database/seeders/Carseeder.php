<?php

namespace Database\Seeders;

use App\Models\CarModel;
use Illuminate\Database\Seeder;

class Carseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [ 'id' => '1',
                'car_license' => 'กฉ 2555 เชียงใหม่',
        'car_model'  => 'toyota vego 4dor',
        'car_status'    => '1'
          
            ],
            ['id' => '2',
                'car_license' => 'ฮก 6223 เชียงใหม่',
                'car_model'  => 'ford ranger raptor',
                'car_status'    => '1'
         
            ],    ['id' => '3',
                'car_license' => 'บน 1133 เชียงใหม่',
                'car_model'  => 'Isuzu D-max 4dor',
                'car_status'    => '1'
          
            ],
          
        ];
        foreach($user as $key => $value){
             CarModel::create($value);
        }
        //
        //
    }
}
