@extends('layouts.admin.admin')
@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5  ">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div  class=" col-12  flex-column d-flex justify-content-between align-items-center ">
                {{-- ///////////////////// --}}
                <div class="box h-100 col-md col align-self-start p-3">
                    <div class="row p-2" style="gap: 10px">
                        @foreach ($car as $cars)
                            <div class=" col-12 col-sm-5 col-lg col-md-12 shadow-box rounded ">
                                <div class=" box-1 bg-dark-2 box p-3">
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
                {{-- ////////////////////////////// --}}
                <div class=" col-md-4 col-12 row w-100 " style="height: 100%; max-height:350px">
                    <div class=" col-12 bg-dark-2 h-100 w-100 rounded ">
                        <div class="  rounded h-100 w-100 " style=" height:100%; width:100%; ">
                            <canvas id="myChart"></canvas>
                        </div>

                    </div>

                </div>
            </div>
            <div class=" col-12 flex-md-row flex-column d-flex justify-content-between align-items-center  mt-2 p-3 ">
                <div class="p-2 col-12 col-md-8">
                    <div class="bg-dark-2 rounded">
                         <div id="Chart">cvcvc</div>
                    </div>

                </div>
                <div class=" col p-2 ">
                    <div class="bg-dark-2 rounded" >dgdg</div>
                </div>
            </div>
            {{-- ///////////////////////////////////////////////////////////////////////////////////////// --}}


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
