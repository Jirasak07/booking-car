@extends('layouts.admin.admin')
@section('content')
    @include('layouts.admin.header')
    <div class="container ">
        <div class="d-flex flex-column justify-content-center align-items-center ">
            <div class=" col-12  flex-column d-flex justify-content-between align-items-center  ">
                {{-- ///////////////////// --}}
                <div class="box h-100 col-md-12 col-12 align-self-start p-3">
                    <div class="row p-2" style="gap: 20px">
                        @foreach ($car as $cars)
                            <div class=" col-12 col-sm-12 col-lg col-md-12 shadow-box rounded font-w w-100 d-flex justify-content-center"
                                style="font-size: larger">
                                <div class=" box-1  box p-3">
                                    <div class="d-flex row ">
                                        <div class="col ">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="text-success" style="font-size: 2.5rem; font-weight:600">0
                                                </div>
                                                <div class="margin-left text-dark"
                                                    style="font-size: 0.8rem; font-weight:bolder; margin-left:5px">รายการ
                                                </div>
                                            </div>
                                            <div class="text-success text-capitalize"
                                                style="font-size: 0.8rem; font-weight:600">
                                                {{ $cars['car_model'] }}
                                            </div>
                                            <div class="text-dark" style="font-size: 0.7rem">{{ $cars['car_license'] }}
                                            </div>
                                        </div>
                                        <div class=" w-100 col-2 d-flex align-items-center justify-content-center  ">
                                            <div class="car-icon-2  ">
                                                <i class="fa-solid fa-car-side text-light" style="font-size: 3rem"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex flex-column  flex-xl-row  align-items-center p-1"
                style="justify-content: space-evenly; gap:20px">
                <div class="rounded shadow-box box-1 box col-md-12 col-sm-12 col-lg-5 col-12 row w-100 chart "
                    style="height: 100%; max-height:350px; ">
                    <div class=" col-12  h-100 w-100 rounded ">
                        <div class="  rounded h-100 w-100 " style=" height:100%; width:100%;  ">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="rounded shadow-box box-1 box col-md-12 col-sm-12 col-lg-5 col-12 row w-100 chart  "
                    style="height: 100%; max-height:350px;  ">
                    <div class=" col-12   rounded ">
                        <div class=" text-capitalize rounded d-flex align-items-center "
                            style=" min-height:300px; width:100%;  ">
                            <canvas id="Chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex row flex-lg-row flex-column justify-content-center align-items-center p-3 ">
        </div>
        <div class="rounded shadow-box-1 bg-new mb-5 text-center p-2 " style="height: 100%;font-weight:700;">
            @include('admin.calendar_show')
        </div>
    </div>

















    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'doughnut',

                data: data = {
                    labels: [
                        'รถภายใน',
                        'รถภายนอก',

                    ],
                    datasets: [{
                        label: 'มีการใช้งาน ครั้ง',
                        data: [5, 2],
                        backgroundColor: [
                            '#2dce89',
                            '#fb6340',

                        ],
                        borderColor: ['#2dce89', '#fb6340'],
                        hoverOffset: 4
                    }]
                },
                options: {

                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'สัดส่วนการใช้งานของรถภายในและรถภายนอก'
                        }
                    }
                }
            });


        })
        var ctx = document.getElementById('Chart');
        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
            'Oct', 'Nov', 'Dec'
        ];
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'รถภายใน',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: '#2dce89',
                    borderColor: '#2dce89',
                    borderWidth: 1
                }, {
                    label: 'รถภายนอก',
                    data: [22, 29, 13, 15, 12, 13],
                    backgroundColor: '#fb6340',
                    borderColor: '#fb6340',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'การใช้งานของรถภายในและรถภายนอกในปี 2565'
                    }
                }
            }
        });
    </script>
@endsection
