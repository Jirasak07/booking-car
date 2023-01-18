@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
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
                    @foreach ($hiss as $history)
                        @if ($history['booking_status'] == 2 || $history['booking_status'] == 3)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $history['name'] }}</td>
                                <td>{{ $history['type_car'] }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($history['booking_start'])) }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($history['booking_end'])) }}</td>
                                <td>
                                    @if ($history['booking_status'] == 2)
                                        <div class="text-success">{{ __('อนุมัติ') }}</div>
                                    @elseif ($history['booking_status'] == 3)
                                        <div class="text-danger">{{ __('ยกเลิก') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn btn-sm bg-primary text-white"> <i class="fa-solid fa-eye"></i></div>

                                </td>

                            </tr>
                        @endif
                    @endforeach
                            {{-- @foreach ($hiss as $his)
                                <tr>
                                    <td>{{$his['name']}}</td>
                                </tr>
                            @endforeach --}}
                </tbody>
            </table>

            {{-- @foreach ($his as $his)
            <div>{{$his['id']}}</div>
            @endforeach --}}
        </div>

        {{-- @include('layouts.footers.auth') --}}
    </div>
    </div>
    <script>
        var his = @json($hiss);
        console.log(his)
    </script>
@endsection
