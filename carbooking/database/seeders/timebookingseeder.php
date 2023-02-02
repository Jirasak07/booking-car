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
                'unit' => 'hours',
                'unit_th' => 'ชม.',
               
            ],  ['id' => '2',
            'name' => 'จองล่วงหน้านานสุด',
            'time'    => '1',
            'unit' => 'days',
            'unit_th' => 'วัน',
         
        ],
            ['id' => '3',
                'name' => 'ระยะเวลาในการจองขั้นต่ำ',
                'time'    => '3',
                'unit' => 'month',
                'unit_th' => 'เดือน',
              
            ],
            ['id' => '4',
                'name' => 'ระยะเวลาในการจองขั้นสูงสุด',
                'time'    => '3',
                'unit' => 'hours',
                'unit_th' => 'ชม.',
            ],
          
          
        ];
        foreach($user as $key => $value){
             timebookingModel::create($value);
        }
    }
}