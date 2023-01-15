@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card-dark shadow-box rounded ">
                <table class=" rounded table table-light  fw-bold table-responsive-sm">
                    <thead class="table-dark">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>หมายเลขทะเบียน</td>
                            <td>รายละเอียดรถ</td>
                            <td>สถานะ</td>

                        </tr>
                    </thead>
                    <tbody>
                    @foreach($car as $cars)
                        <tr>
                            <td>{{$cars['id']}}</td>
                            <td>{{$cars['car_license']}}</td>
                            <td>{{$cars['car_model']}}</td>

                            <td>
                                @if($cars['car_status']==1)
                                <a class="btn btn-success btn-sm " style="width: 90px" href="{{route("changestatus",$cars['id'])}}">{{__('พร้อมใช้งาน')}}</a>
                                @elseif($cars['car_status'] ==2)
                                <a class="btn btn-danger btn-sm " style="width: 90px" href="{{route("changestatus",$cars['id'])}}">{{__('ไม่พร้อมใช้งาน')}}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
