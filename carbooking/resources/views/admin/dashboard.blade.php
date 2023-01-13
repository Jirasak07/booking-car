@extends('layouts.admin.admin')
@section('content')
    @include('layouts.admin.header')
    <div class="container-sm mt-3 ">
        <div class="d-flex flex-lg-row flex-column mx-3  mb-3" style="gap: 20px;min-height:120px">
            <div class="w-100  m-dash">
                <div class="bg-white  h-100 booking-all p-2 d-flex flex-row align-items-center" style="min-height:120px">
                    <div class="col-8 ">
                        <div class="text-default ">รายการจองทั้งหมด</div>
                        <div style="font-size: 4rem;line-height: 80%;">0</div>
                        <div>รายการ</div>
                    </div>
                    <div class="icon-d-2 icon-circle bg-default"><i class="fa-solid fa-clipboard-list  icon-dashboard "></i>
                    </div>
                </div>
            </div>
            <div class="w-100  m-dash">
                <div class=" bg-white h-100 confirm p-2 d-flex flex-row align-items-center"style="min-height:120px">
                    <div class="col-8 ">
                        <div>อนุมัติแล้ว</div>
                        <div style="font-size: 4rem;line-height: 80%;">0</div>
                        <div class="text-default">รายการ</div>
                    </div>
                    <div class="icon-d-2 icon-circle bg-success"><i class="fa-solid fa-circle-check icon-dashboard "></i>
                    </div>
                </div>
            </div>
            <div class="w-100  m-dash">
                <div class=" bg-white h-100 pending p-2 d-flex flex-row align-items-center " style="min-height:120px">
                    <div class="col-8 ">
                        <div>รอดำเนินการ</div>
                        <div style="font-size: 4rem;line-height: 80%;">0</div>
                        <div class="text-default">รายการ</div>
                    </div>

                    <div class="icon-d-2 icon-circle bg-yellow "> <i class="fa-solid fa-hourglass-end icon-dashboard "></i>
                    </div>
                </div>
            </div>
            <div class="w-100  m-dash">
                <div class=" bg-white h-100 w-100 cancel p-2 d-flex flex-row align-items-center" style="min-height:120px">
                    <div class="col-8  ">
                        <div>ยกเลิกแล้ว</div>
                        <div style="font-size: 4rem;line-height: 80%;">0</div>
                        <div class="text-default ">รายการ</div>
                    </div>
                    <div class="icon-d-2 icon-circle bg-danger"><i class="fa-solid fa-circle-xmark icon-dashboard "></i>
                    </div>
                </div>
            </div>
        </div>
        <div class=" d-flex flex-column justify-content-between flex-lg-row pb-2  w-100">
            <div class="mt-3   col-12 col-lg-8 ">
                <canvas class="bg-white  w-100 h-100 " style=" max-height: 400px;" id="Chart"></canvas>
            </div>
            <div class="mt-3  col-12 col-lg-4">
                <canvas class=" bg-white  w-100 " style=" max-height: 400px;" id="myChart"></canvas>
            </div>

        </div>
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 ">
            <div class="flex-column flex-lg-row d-flex justify-content-between  w-100  ">
                @foreach ($car as $cars)
                    <div class="col-12 col-lg  mt-3 w-100 ">
                        <div class="bg-white   d-flex flex-row p-2  "
                            style="min-height: 120px;border-left:5px solid var(--warning)">
                            <div class="title-cars ml-3 col-6">
                                <div class="brand-car text-warning text-capitalize"
                                    style="font-size: 1.2em;font-weight:500"> {{ $cars['car_model'] }}</div>
                                <div class="lc_car text-default" style="font-size: 0.8em;font-weight:500;">
                                    {{ $cars['car_license'] }}</div>
                                <div class="res_car  ml-3" style="font-size:3rem;line-height:80%;">0</div>
                                <div class="text-default ml-3" style="font-size: 0.8em"> รายการ</div>
                            </div>
                            <div class="logo-car  col-6" style="font-size: 6rem;line-height:80%;opacity:0.3"><i
                                    class="fa-solid fa-car-rear text-warning"></i></div>


                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card mx-3 p-3 mb-3">
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
                responsive: true,
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
        var ctx1 = document.getElementById('chart1').getContext('2d');
        var chart1 = new Chart(ctx1, {
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
                responsive: true,
                // other options
            }
        });

        var ctx2 = document.getElementById('chart2').getContext('2d');
        var chart2 = new Chart(ctx2, {
            type: 'line',
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
                responsive: true,
                // other options
            }
        });
    </script>
@endsection
