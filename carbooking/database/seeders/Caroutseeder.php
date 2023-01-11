<?php

namespace Database\Seeders;

use App\Models\CaroutModel;
use Illuminate\Database\Seeder;

class Caroutseeder extends Seeder
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
                'id' => '1',
                'car_out_license' => 'กจ 2334 เชียงใหม่',
                'car_out_model'    => 'toyota Hilux vego 4dor',
                'car_out_driver' => 'สุรพล สมบัติทัวร์',
                'car_out_tel'    => '099-925 5204',
                'car_out_status' => '1'
                
            ],
            [
                'id' => '2',
                'car_out_license' => 'บม 8556',
                'car_out_model'    => 'ford ranger raptor 2020 4dor',
                'car_out_driver' => 'สมชาย วงเวียน',
                'car_out_tel'    => '063-344 8944',
                'car_out_status' => '1'
                
            ]
        ];
        foreach($user as $key => $value){
            CaroutModel::create($value);
       }
    }
}
