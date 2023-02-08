@component('mail::message')
# อนุมัติการจองรถ Lannacom


<h1 style="color: teal">รายการจองของคุณได้รับการอนุมัติเรียบร้อย ✅</h1>
<h5>รถ :{{ $data['car'] }}</h5>
<h5>ทะเบียน :{{ $data['license'] }}</h5>
<h5>คนขับ :{{ $data['driver'] }}</h5>
<h5>เวลาเริ่มต้น : {{ thaidate('l ที่ j F Y เวลา G:i ', strtotime($data['sdate'])) }}</h5>
<h5>เวลาสิ้นสุด : {{ thaidate('l ที่ j F Y เวลา G:i ', strtotime($data['edate'])) }}</h5>
<h5>รายละเอียด :{{ $data['detail'] }}</h5>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
