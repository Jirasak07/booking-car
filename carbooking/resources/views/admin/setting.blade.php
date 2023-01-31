@extends('layouts.layout')
@section('content')
    @include('layouts.header')

    <div class="container">
        <div class="text-capitalize pt-3 pl-3"><i class="fa-solid fa-gears mr-3"
                style="font-size: 2rem;"></i>จัดการข้อมูลพื้นฐานของระบบ</div>
                <div class="d-flex flex-md-row flex-column justify-constent-center bg-success pt-3 px-3" style="gap: 10px"  >
                     <div class="col-md-6 col-12 d-flex  flex-column " style="gap: 10px">
                        <div class="bg-white rounded">1</div>
                        <div class="bg-white rounded">2</div>
                     </div>
                     <div class="col-md-6 col-12 d-flex  flex-column " style="gap: 10px">
                        <div class="bg-white rounded">3</div>
                        <div class="bg-white rounded">4</div>
                     </div>
                </div>

    </div>
@endsection
