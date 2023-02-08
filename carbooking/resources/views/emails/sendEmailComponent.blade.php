@component('mail::message')
# อนุมัติการจองรถ Lannacom


<h1 style="color: teal">รายการจองของคุณได้รับการอนุมัติเรียบร้อย</h1>
<h5>รถ :{{ $data['car'] }}</h5>
<h5>ทะเบียน :{{ $data['license'] }}</h5>
<h5>คนขับ :{{ $data['driver'] }}</h5>
<h5>เวลา :{{ $data['sdate'] }}-{{ $data['edate'] }}</h5>
<h5>รายละเอียด :{{ $data['detail'] }}</h5> 



Thanks,<br>
{{ config('app.name') }}
@endcomponent
