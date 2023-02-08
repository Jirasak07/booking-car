@component('mail::message')
# มีรายการจองใหม่

<h1>{{ $data['title'] }}</h1>

<h5>เวลาเริ่มต้น : {{ thaidate('l ที่ j F Y เวลา G:i ', strtotime($data['sdate'])) }}</h5>
<h5>เวลาสิ้นสุด : {{ thaidate('l ที่ j F Y เวลา G:i ', strtotime($data['edate'])) }}</h5>
<h5>รายละเอียด :{{ $data['detail'] }}</h5>

@component('mail::button', ['url' => 'https://www.youtube.com/'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
