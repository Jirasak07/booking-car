@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-sm mx-3 mt-2 pt-3">
        <div class=" card p-2   ">
            <table id="tablehistory" class="display responsive nowrap " style="width:100%;font-size:0.8em">
                <thead class="table-dark table-hover">
                    <tr>
                        <th style="max-width: 30px">ลำดับ</th>
                        <th>ผู้จอง</th>
                        <th>วันเวลาเริ่มต้น</th>
                        <th>วันเวลาสิ้นสุด</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>

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
    @push('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                $('#tablehistory').DataTable({
                    responsive: {
                        details: false
                    },
                    columnDefs: [
                        {
                            responsivePriority: 1,
                            targets: 4
                        },
                        {
                            responsivePriority: 2,
                            targets: 5
                        },

                    ],
                    lengthMenu: [10, 20, 50, 100, ],
                    language: {
                        lengthMenu: "แสดง _MENU_ รายการ",
                        search: "ค้นหาข้อมูลในตาราง",
                        info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",

                        paginate: {

                            previous: "ก่อนหน้า",
                            next: "ถัดไป",

                        },
                    },
                });
            })
        </script>

        <script>
            var his = @json($hiss);
            console.log(his)
        </script>
    @endpush
@endsection
