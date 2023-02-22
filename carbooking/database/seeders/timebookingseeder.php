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
                'name' => 'จองล่วงหน้าขั้นต่ำ',
                'time'    => '5',
                'unit' => 'hours',
                'unit_th' => 'ชม.',
               
            ],  ['id' => '2',
            'name' => 'จองล่วงหน้านานสุด',
            'time'    => '1',
            'unit' => 'month',
            'unit_th' => 'เดือน',
         
        ],
            ['id' => '3',
                'name' => 'จองขั้นต่ำ',
                'time'    => '2',
                'unit' => 'hours',
                'unit_th' => 'ชม.',
              
            ],
            ['id' => '4',
                'name' => 'จองสูงสุด',
                'time'    => '3',
                'unit' => 'day',
                'unit_th' => 'วัน.',
            ],
          
          
        ];
        foreach($user as $key => $value){
             timebookingModel::create($value);
        }
    }
}