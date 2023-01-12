@extends('layouts.admin.admin')
@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid bg-danger ">
        <div class="d-flex flex-column justify-content-center align-items-center ">
            <div class=" col-12  flex-column d-flex  align-items-center ">
                {{-- ///////////////////// --}}
                <div class=" h-100 col-md-12 col-12 align-self-start ">
                    <div class="row  d-flex justify-content-between" style="gap: 10px">
                        @foreach ($car as $cars)
                            <div class=" col-12 col-sm-12 col-lg col-md-12 shadow-lg bg-white rounded font-w w-100 d-flex justify-content-center"
                                style="font-size: larger; gap:20px">
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

        </div>
        <div class=" d-flex flex-column justify-content-between flex-lg-row px-3 mb-3 pb-2 bg-warning w-100">
            <canvas class="mt-3 rounded bg-white col-6 " style=" max-height: 400px;" id="Chart"></canvas>
            <canvas class="mt-3 rounded bg-info col-6 mxw " id="myChart"></canvas>
        </div>
        <div class="card mx-3">
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
