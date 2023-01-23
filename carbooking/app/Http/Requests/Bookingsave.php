<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Bookingsave extends FormRequest
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
            'booking_start' => 'required|before:5 hours',
            'booking_end' => 'required',
            'booking_deatil' => 'required',
           
            // 'tel' => 'required|numeric|digits_between:8,15',
            //
        ];
    }
    
    public function messages()
    {
        return [
            'booking_start.required' => 'โปรดระบุวันที่เริ่มจอง',
            'booking_end.required' => 'โปรดระบุวันที่สิ้นสุดการจอง',
            'booking_deatil.required' => 'โปรดระบุรายละเอียดและสถานที่ที่จะไป',
            // 'email.email' => 'รูปแบบอีเมล์ไม่ถูกต้อง',
            // 'tel.numeric' => 'ระบุเฉพาะตัวเลขเท่านั้น',
            // 'tel.digits_between' => 'เบอร์โทรต้องมี 8 - 15 ตัว',
        ];
    }
}
