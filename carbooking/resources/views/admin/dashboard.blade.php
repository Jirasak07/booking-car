@extends('layouts.admin.admin')
@section('content')
    @include('layouts.admin.header')
    <div class="container ">
        <div class="d-flex flex-column justify-content-center align-items-center ">
            <div class=" col-12  flex-column d-flex justify-content-between align-items-center  ">
                {{-- ///////////////////// --}}
                <div class="box h-100 col-md-12 col-12 align-self-start p-3">
                    <div class="row p-2" style="gap: 10px">
                        @foreach ($car as $cars)
                            <div class=" col-12 col-sm-12 col-lg col-md-12 shadow-box rounded ">
                                <div class=" box-1  box p-3">
                                    <div class="d-flex row ">
                                        <div class="col ">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="text-info" style="font-size: 2.5rem">0 </div>
                                                <div class="margin-left text-white" style="font-size: 0.6rem">รายการ</div>
                                            </div>
                                            <div class="text-info text-capitalize" style="font-size: 0.7rem">
                                                {{ $cars['car_model'] }}
                                            </div>
                                            <div class="text-white" style="font-size: 0.5rem">{{ $cars['car_license'] }}
                                            </div>
                                        </div>
                                        <div class=" w-100 col-5 d-flex align-items-center justify-content-center  ">
                                            <div class="car-icon-2  ">
                                                <img src="{{ asset('assets/img/car.png') }}" width="40px"
                                                    class="car-icon" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex flex-column flex-lg-row justify-content-between align-items-center p-1">
                <div class="rounded shadow-box box-1 box col-md-12 col-sm-12 col-lg-4 col-12 row w-100 "
                    style="height: 100%; max-height:350px">
                    <div class=" col-12  h-100 w-100 rounded ">
                        <div class="  rounded h-100 w-100 " style=" height:100%; width:100%;  ">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="rounded shadow-box box-1 box col-md-12 col-sm-12 col-lg-4 col-12 row w-100 "
                style="height: 100%; max-height:350px">
                <div class=" col-12   rounded ">
                    <div class="  rounded " style=" min-height:300px; width:100%;  ">
                        <canvas class="h-100" id="myChart">1</canvas>
                    </div>
                </div>
            </div>
                <div class="rounded shadow-box box-1 box col-md-12 col-sm-12 col-lg-4 col-12 row w-100">
                    <div class="h-100">2</div>
                </div>
            </div>
        </div>
        <div class="d-flex row flex-lg-row flex-column justify-content-center align-items-center p-3 ">
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart');
            const bar = document.getElementById('Chart');
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
                            '#205295',
                            '#EFEFEF',

                        ],
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
    </script>
@endsection
