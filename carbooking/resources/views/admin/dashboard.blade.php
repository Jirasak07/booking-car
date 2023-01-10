@extends('layouts.admin.admin')
<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5  ">
        <div class="row d-flex justify-content-center" style="gap: 10px">
            {{-- ///////////////////////////////////////////////////////////////////////// --}}
            {{-- <div class="card col-lg-3 col-md-5 col-10  box-card  ">
                <div class="text-warning d-flex  align-items-center flex-column self  ">
                    <div class="mt-3 fw-bolder" style="font-size: 1.5rem"> TOYOTA HILUX Revo</div>
                    <div>2กวว เชียงใหม่ 415</div>
                    <div class="d-flex align-items-center " style="gap: 10px">
                        <div class="text-success">
                            สัปดาห์นี้
                        </div>
                        <div class="text-dark  " style="font-size: 5rem">0</div>
                        <div class="text-test ">รายการ</div>
                    </div>
                </div>

                <div class=" w-100 h-100 d-flex justify-content-end align-items-end">

                    <img src="{{ asset('assets/img/car.png') }}" width="120px" class="car-icon" />
                </div>
            </div> --}}
            <div class=" col-12 flex-md-row flex-column d-flex justify-content-center  " style="gap: 10px">
                {{-- ///////////////////// --}}
                <div class="box  col-md-5 ">
                    <div class="row">
                        @foreach ($car as $cars)
                            <div class=" col-12 col-sm-6 col-lg-6 col-md-12 p-1  ">
                                <div class="bg-dark-2 card box p-2">
                                    <div class="d-flex row ">
                                        <div class="col ">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="text-primary" style="font-size: 2.5rem">0 </div>
                                                <div class="margin-left" style="font-size: 0.6rem">รายการ</div>
                                            </div>
                                            <div class="text-primary text-capitalize" style="font-size: 0.7rem">
                                                {{ $cars['car_model'] }}
                                            </div>
                                            <div class="text-light" style="font-size: 0.5rem">{{ $cars['car_license'] }}
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
                <div class="col-md-6 p-1 ">
                    <div class=" card h-100 p-1 bg-dark-2">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ///////////////////////////////////////////////////////////////////////////////////////// --}}


        </div>
    @endsection
