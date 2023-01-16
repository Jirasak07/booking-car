@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-sm mx-3 mt-2">
        <div class="shadow-table">

            <table class="rounded table table-md  table-white table-striped fw-bold table-responsive-lg">
                <thead class="table-dark table-hover">
                    <tr>
                        <td class="fw-bold">ลำดับ</td>
                        <td>ผู้จอง</td>
                        <td>วันเวลาเริ่มต้น</td>
                        <td>วันเวลาสิ้นสุด</td>
                        <td>สถานะ</td>
                        <td>รายละเอียด</td>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($history as $history)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{ $history['username'] }}</td>
                            <td>{{ $history['booking_start'] }}</td>
                            <td> {{ $history['booking_end'] }}</td>
                            <td>
                                @if ($history['booking_status']==2)
                                    <div class="text-success">{{__('อนุมัติ')}}</div>
                                @elseif ($history['booking_status']==3)
                                <div class="text-danger">{{__('ยกเลิก')}}</div>
                                @endif
                            </td>
                            <td>
                                <div class="btn btn-sm bg-primary text-white"> <i class="fa-solid fa-eye"></i></div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- @include('layouts.footers.auth') --}}
    </div>
    </div>
@endsection
