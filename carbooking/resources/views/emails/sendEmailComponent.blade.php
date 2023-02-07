@component('mail::message')
# Introduction

<h1>{{ $data['license'] }}</h1>
<h1 style="color: teal">การจองนี้อนุมัติเรียบร้อย</h1>
{{-- <h5>รถ :{{ $data['car'] }}</h5>
<h5>ทะเบียน :{{ $data['license'] }}</h5>
<h5>คนขับ :{{ $data['driver'] }}</h5>
<h5>เวลา :{{ $data['sdate'] }}-{{ $data['edate'] }}</h5>
<h5>รายละเอียด :{{ $data['detail'] }}</h5> --}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
