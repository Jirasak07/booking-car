@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card-dark  shadow-b overflow-auto">
                <table class=" rounded table table-light  fw-bold table-md">
                    <thead class="table-dark table-hover">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>รายชื่อ</td>
                            <td>สถานะ</td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($driver as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td>{{$item['driver_fullname']}}</td>
                           
                            <td>
                            @if($item['driver_status'] == 1)
                                <a class="btn btn-success btn-sm" href="{{route("driverstatus",$item['id'])}}">{{__('ว่าง')}}</a>
                                @elseif($item['driver_status'] == 2)
                                <a class="btn btn-danger btn-sm" href="{{route("driverstatus",$item['id'])}}">{{__('ไม่ว่าง')}}</a>
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
