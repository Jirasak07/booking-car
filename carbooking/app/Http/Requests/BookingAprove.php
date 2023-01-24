<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingAprove extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'car_out_license' => 'required|min:3',
            'brand' => 'required|min:3',
            'car_out_model' => 'required|min:10',
            'owner' => 'required|min:5',
            'car_out_driver' => 'required|min:10',
            'car_out_tel' => 'required|numeric|digits_between:8,15',
           
            // 'tel' => 'required|numeric|digits_between:8,15',
            //
        ];
    }
    
    public function messages()
    {
        return [
            'car_out_license.required' => 'โปรดระบุทะเบียน',
            'brand.required' => 'โปรดระบุยี่ห้อรถ',
            'car_out_model.required' => 'โปรดระบุรายละเอียดรุ่นรถ',
            'owner.required' => 'โปรดระบุชื่อเจ้าของรถ',
            'car_out_driver.required' => 'โปรดระบุชื่อคนขับ',
            'car_out_tel.required' => 'โปรดระบุเบอร์โทรเจ้าของรถ',
            // 'email.email' => 'รูปแบบอีเมล์ไม่ถูกต้อง',
            'car_out_tel.numeric' => 'ระบุเฉพาะตัวเลขเท่านั้น',
            'car_out_tel.digits_between' => 'เบอร์โทรต้องมี 8 - 15 ตัว',
        ];
    }
}
