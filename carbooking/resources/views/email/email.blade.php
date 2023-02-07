@component('mail::message')
# Introduction

<h1>{{ $data['title'] }}</h1>
<h1>{{ $data['body'] }}</h1>
<h1>{{ $data['sdate'] }}</h1>
<h1>{{ $data['edate'] }}</h1>
<h1>{{ $data['detail'] }}</h1>

@component('mail::button', ['url' => 'https://www.google.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
