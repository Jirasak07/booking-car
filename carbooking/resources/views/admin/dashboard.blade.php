@extends('layouts.admin.admin')
@section('content')
    @include('layouts.admin.header')
    <div class="container-sm mt-3 ">
        <div class="d-flex flex-xl-row flex-column mx-3   " style="gap: 10px;min-height:120px">
            <div class="w-100 m-dash">
                <div class=" h-100 booking-all d-flex flex-row align-items-center" style="min-height:120px">
                    <div class="h-100 col text-white icon-d-2  icon-circle">
                        <i class="fa-solid fa-clipboard-list  icon-dashboard "></i>
                    </div>
                    <div class="col d-flex flex-column align-items-center text-white">
                        <div class="text-white ">รายการจองทั้งหมด</div>
                        <div style="font-size: 4rem;line-height: 80%;"id="all" >0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>
            <div class="w-100  m-dash">
                <div class="text-white h-100 confirm d-flex flex-row align-items-center"style="min-height:120px">

                    <div class="h-100  col icon-d-2 icon-circle  "><i class="fa-solid fa-circle-check icon-dashboard "></i>
                    </div>
                    <div class="col  d-flex flex-column align-items-center  ">
                        <div>อนุมัติแล้ว</div>
                        <div style="font-size: 4rem;line-height: 80%;" id="approve">0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>
            <div class="w-100  m-dash">
                <div class="  h-100 pending  d-flex flex-row align-items-center " style="min-height:120px">
                    <div class="h-100 col icon-d-2 icon-circle  "> <i class="fa-solid fa-hourglass-end icon-dashboard "></i>
                    </div>
                    <div class="col text-white d-flex flex-column align-items-center">
                        <div>รอดำเนินการ</div>
                        <div style="font-size: 4rem;line-height: 80%;" id="pending">0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>
            <div class="w-100  m-dash">
                <div class=" bg-danger h-100 w-100 cancel  d-flex flex-row align-items-center" style="min-height:120px">

                    <div class="h-100 icon-d-2 icon-circle col"><i class="fa-solid fa-circle-xmark icon-dashboard "></i>
                    </div>
                    <div class="col text-white d-flex flex-column align-items-center ">
                        <div>ยกเลิกแล้ว</div>
                        <div style="font-size: 4rem;line-height: 80%;" id="cancel">0</div>
                        <div>รายการ</div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" d-flex flex-column justify-content-between flex-lg-row pb-2  w-100">
            <div class="mt-3   col-12 col-lg-8 ">
                <canvas class="bg-white  w-100 h-100 " style=" max-height: 420px;" id="Chart"></canvas>
            </div>
            <div class="mt-3  col-12 col-lg-4">
                <canvas class=" bg-white  w-100 " style=" max-height: 420px;" id="myChart"></canvas>
            </div>
        </div>
        <div class="d-flex flex-column justify-content-center align-items-center mb-3 ">
            <div class="flex-column flex-lg-row d-flex justify-content-between  w-100  ">
                @foreach ($car as $cars)
                    <div class="col-12 col-lg  mt-3 w-100 ">
                        <div class=" bg-info  d-flex flex-row p-2 m-dash " style="min-height: 120px;">

                            <div class="logo-car  col-6 text-white" style="font-size: 6rem;line-height:80%;"><i
                                    class="fa-solid fa-car-rear "></i></div>
                            <div class="title-cars ml-3 col-6">
                                <div class="brand-car text-white text-capitalize" style="font-size: 1em;font-weight:500">
                                    {{ $cars['car_model'] }}</div>
                                <div class="lc_car text-white" style="font-size: 0.8em;font-weight:500;">
                                    {{ $cars['car_license'] }}</div>
                                <div class="res_car  ml-3 text-white" style="font-size:3rem;line-height:80%;"
                                    id="tcar-{{ $cars['id'] }}"></div>
                                <div class="text-white ml-3" style="font-size: 0.8em"> รายการ</div>
                            </div>
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
            var allbook = @json($allbook);
            var car = @json($car);
            console.log(car);
            var total_car = 1;
            $('#tcar-1').html(total_car);
            const ctx = document.getElementById('myChart');
            document.getElementById('all').innerHTML = allbook;
            document.getElementById('pending').innerHTML = @json($pending);
            document.getElementById('cancel').innerHTML = @json($cancel);
            document.getElementById('approve').innerHTML = @json($approve);
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
    </script>
@endsection
