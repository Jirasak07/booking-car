@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5  ">
        <div class="row d-flex justify-content-center" style="gap: 10px">
            {{-- ///////////////////////////////////////////////////////////////////////// --}}
            <div class="card col-lg-3 col-md-5 col-10  box-card  ">
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
            </div>
            <div class="card col-lg-3 col-md-5 col-10  box-card  ">
                <div class="text-warning d-flex  align-items-center flex-column self  ">
                    <div class="mt-3 fw-bolder" style="font-size: 1.5rem"> TOYOTA HILUX Revo</div>
                    <div>2กวว เชียงใหม่ 415</div>
                    <div class="d-flex align-items-center " style="gap: 10px">
                        <div class="text-success">
                            สัปดาห์นี้
                        </div>
                        <div class="text-dark  " style="font-size: 5rem">0</div>
                        <div class="text-success ">รายการ</div>
                    </div>
                </div>

                <div class=" w-100 h-100 d-flex justify-content-end align-items-end">

                    <img src="{{ asset('assets/img/car.png') }}" width="120px" class="car-icon" />
                </div>
            </div>
            <div class="card col-lg-3 col-md-5 col-10  box-card  ">
                <div class="text-warning d-flex  align-items-center flex-column self  ">
                    <div class="mt-3 fw-bolder" style="font-size: 1.5rem"> TOYOTA HILUX Revo</div>
                    <div>2กวว เชียงใหม่ 415</div>
                    <div class="d-flex align-items-center " style="gap: 10px">
                        <div class="text-success">
                            สัปดาห์นี้
                        </div>
                        <div class="text-dark  " style="font-size: 5rem">0</div>
                        <div class="text-success ">รายการ</div>
                    </div>
                </div>

                <div class=" w-100 h-100 d-flex justify-content-end align-items-end">

                    <img src="{{ asset('assets/img/car.png') }}" width="120px" class="car-icon" />
                </div>
            </div>
        </div>
        {{-- ///////////////////////////////////////////////////////////////////////////////////////// --}}
        <div class="mt-3 d-flex row justify-content-center" style="gap: 10px">
            <div class="card col-md-5">dbdbd</div>
            <div class="card col-md-5">dbdbd</div>
        </div>

    </div>
@endsection
