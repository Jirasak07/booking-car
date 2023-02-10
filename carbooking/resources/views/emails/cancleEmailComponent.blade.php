@component('mail::message')
# ยกเลิกการจอง

<h3>{{$data->title}}</h3>
<h3>{{$data->detail}}</h3>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
