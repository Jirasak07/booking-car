<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/email.css') }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" />
    <title>BookingCar</title>
</head>

<body>
    <div
        style="width: 190px;
    height: 254px;
    margin: 0 auto;
    background-color: #F8FBFE;
    border-radius: 8px;
    z-index: 1;
    font-size:small;
    display:flex;
    justify-content:center;">
        <h1>{{ $data['title'] }}</h1>
        <h1>{{ $data['body'] }}</h1>
        <h1>thank you</h1>

    </div>
    <a style=" color: #090909;
    padding: 0.7em 1.7em;
    font-size: 18px;
    border-radius: 0.5em;
    background: #e8e8e8;
    border: 1px solid #e8e8e8;
    transition: all .3s;
    box-shadow: 6px 6px 12px #c5c5c5,
               -6px -6px 12px #ffffff;"
        href="https://www.youtube.com/watch?v=tBRSH4DQW_Y">ไปดู</a>
</body>

</html>
