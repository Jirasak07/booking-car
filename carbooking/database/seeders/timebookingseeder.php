<?php

namespace Database\Seeders;

use App\Models\timebookingModel;
use Illuminate\Database\Seeder;

class timebookingseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [   'id' => '1',
                'name' => 'การจองล่วงหน้าขั้นต่ำ',
                'time'    => '5',
                'unit' => '1',
               
            ],  ['id' => '2',
            'name' => 'จองล่วงหน้านานสุด',
            'time'    => '1',
            'unit' => '3',
         
        ],
            ['id' => '3',
                'name' => 'ระยะเวลาในการจองขั้นต่ำ',
                'time'    => '3',
                'unit' => '2',
              
            ],
            ['id' => '4',
                'name' => 'ระยะเวลาในการจองขั้นสูงสุด',
                'time'    => '',
                'unit' => '2',
             
            ],
          
          
        ];
        foreach($user as $key => $value){
             timebookingModel::create($value);
        }
    }
}