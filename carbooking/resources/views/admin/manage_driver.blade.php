@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="  shadow-table rounded">
                <table class=" rounded table table-white table-striped fw-bold table-md">
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
                                <div class="btn btn-success btn-sm " style="width: 80px" onclick="clickGF({{$item['id']}})">{{__('ว่าง')}}</div>
                                @elseif($item['driver_status'] == 2)
                                <a class="btn btn-danger btn-sm " style="width: 80px" href="{{route("driverstatus",$item['id'])}}">{{__('ไม่ว่าง')}}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
<script>
    function clickGF(e){
        alert(e);
    }
</script>
    </div>
@endsection
