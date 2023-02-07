@component('mail::message')
# Introduction

<h1>{{ $data['title'] }}</h1>
<h4>มีการอนุมัติแล้ว</h4>
<h5>รถ: {{$data['car']}}</h5>
<h5>ทะเบียน: {{$data['license']}}</h5>
<h5>คนขับ: {{$data['driver']}}</h5>
<h5>เวลา: {{$data['sdate']}} - {{$data['edate']}}</h5>  
<h5>รายระเอียด: {{$data['detail']}}</h5>  
@component('mail::button', ['url' => 'https://www.google.com/'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
