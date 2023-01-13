@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5  ">
        <div class=" shadow-table ">
            <div class="">
                <table class="rounded table table-md  table-white table-striped fw-bold table-responsive-xl">
                    <thead class="table-dark table-hover">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>ผู้จอง</td>
                            <td>วันเวลาเริ่มต้น</td>
                            <td>วันเวลาสิ้นสุด</td>
                            <td>รายละเอียด</td>
                            <td>จัดการ</td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking as $bookings)
                            <tr>
                                <td>1</td>
                                <td>จิรศักดิ์ สิงหบุตร</td>
                                <td>{{ $bookings['booking_start'] }}</td>
                                <td>{{ $bookings['booking_end'] }}</td>
                                <td>{{ $bookings['booking_detail'] }}</td>
                                <td>
                                    <div class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        อนุมัติ</div>
                                    <a class="text-white btn btn-danger btn-sm " href="{{ route('Test', 2) }}">ยกเลิกคำขอ</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="ml-5 mt-5"> รายการที่เสร็จสิ้น</div>

            <table class="rounded table table-md  table-light table-striped fw-bold table-responsive-xl">
                <thead class="table-dark table-hover">
                    <tr>
                        <td class="fw-bold">ลำดับ</td>
                        <td>ผู้จอง</td>
                        <td>วันเวลาเริ่มต้น</td>
                        <td>วันเวลาสิ้นสุด</td>
                        <td>รายละเอียด</td>
                        <td>ทะเบียนรถ</td>
                        <td>สถานะ</td>

                    </tr>
                </thead>
                <tbody>
                    @foreach($booking as $item)
                        <tr>
                            <td>1</td>
                            <td>จิรศักดิ์ สิงหบุตร</td>
                            <td>{{ $item['booking_start']}}</td>
                            <td>{{ $item['booking_end']}}</td>
                            <td>{{ $item['booking_detail'] }}</td>
                            <td>
                                @if ($item['type_car'] == 1)
                                    <button class="btn-success btn-sm">{{ $item['car_license'] }}
                                    @elseif($item['type_car'] == 2)
                                        <button class="btn-warning btn-sm">{{ $item['car_license']  }}</button>
                                @endif
                            </td>
                            <td>
                                @if ($item['booking_status'] == 1)
                                    <span class="text-primary">{{ __('กำลังกำเนินการ') }}</span>
                                @elseif($item['booking_status'] == 2)
                                    <span class="text-success">{{ __('เสร็จสิ้น') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- @include('layouts.footers.auth') --}}
    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การอนุมัติคำขอ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2  row">
                        <div class="col-6">
                            <label for="" class="form-label " style="line-height:50%">วันเวลาที่เริ่มต้น</label>
                            </br>
                           <label class=" ml-2" style="font-size: 80%;color:#630606;" for="">11012543</label>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label" style="line-height:50%">วันเวลาที่สิ้นสุด</label>
                            </br>
                            <label class=" ml-2" style="font-size: 80%;color:#630606;" for="">11012543</label>
                        </div>
                        <div class="col-12 ">
                            <label for="" class="form-label" style="line-height:50%">รายละเอียดการจอง</label>
                            </br>
                            <label class=" ml-2" style="font-size: 80%;color:#630606;" for="">11012543</label>
                        </div>
                    </div>
                    <div class="d-grid  justify-content-center row gap">

                        <div class="form-check col-5 ">
                            <input onclick="chkform()" class="form-check-input" type="radio" name="g" id="car1"
                                onclick="myfunction()" value="1" checked>
                            <label class="form-check-label" for="1">
                                ใช้รถภายใน
                            </label>
                        </div>
                        <div class="form-check col-5 ">
                            <input onclick="chkform()" class="form-check-input" type="radio" name="g" id="car2"
                                onclick="myfunction()" value="2">
                            <label class="form-check-label" for="2">
                                ใช้รถภายนอก
                            </label>
                        </div>
                    </div>
                    <div id="myDiv"></div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('myDiv').innerHTML =
                ' <form action="{{ route('GG') }}" method="post">' +
                '@csrf' +
                '<div class="form-control py-5 h-100 d-flex flex-row justify-content-around">' +
                ' <div class=" me-2 col-6">' +
                ' <label class="form-label">เลือกรถที่ใช้</label>' +
                '<select name="car" class="form-select rounded px-3 py-2 w-100 " aria-label="Default select example">' +
                '  <option selected value="1">One</option>' +
                ' <option value="2">Two</option>' +
                '  <option value="3">Three</option>' +
                '    </select>' +
                '   </div>' +
                '  <div class=" col-6">' +
                ' <label class="form-label">เลือกพนักงานขับรถ</label>' +
                '  <select name="driver" class="form-select rounded px-3 py-2 w-100 "aria-label="Default select example">' +
                '<option selected value="1">One</option>' +
                '  <option value="2">Two</option>' +
                '  <option value="3">Three</option>' +
                '     </select>' +
                ' </div>' +
                '    </div>' +
                '   <div class="modal-footer">' +
                ' <input type="submit" name="submit" class="btn btn-success" value="อนุมัติ" />' +
                '  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>' +
                '    </div>' +
                '  </form>';
        })

        function chkform() {
            var rd1 = document.getElementById('car1');
            var rd2 = document.getElementById('car2');
            if (rd1.checked == true) {
                var form = "1";
                document.getElementById('myDiv').innerHTML =
                    ' <form action="{{ route('GG') }}" method="post">' +
                    '@csrf' +
                    '<div class="form-control py-5 h-100 d-flex flex-row justify-content-around">' +
                    ' <div class=" me-2 col-6">' +
                    ' <label class="form-label">เลือกรถที่ใช้</label>' +
                    '<select name="car" class="form-select rounded px-3 py-2 w-100 " aria-label="Default select example">' +
                    '  <option selected value="1">One</option>' +
                    ' <option value="2">Two</option>' +
                    '  <option value="3">Three</option>' +
                    '    </select>' +
                    '   </div>' +
                    '  <div class=" col-6">' +
                    ' <label class="form-label">เลือกพนักงานขับรถ</label>' +
                    '  <select name="driver" class="form-select rounded px-3 py-2 w-100 "aria-label="Default select example">' +
                    '<option selected value="1">One</option>' +
                    '  <option value="2">Two</option>' +
                    '  <option value="3">Three</option>' +
                    '     </select>' +
                    ' </div>' +
                    '    </div>' +
                    '   <div class="modal-footer">' +
                    ' <input type="submit" name="submit" class="btn btn-success" value="อนุมัติ" />' +
                    '  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>' +
                    '    </div>' +
                    '  </form>';
            } else if (rd2.checked == true) {
                var form = "2";
                document.getElementById('myDiv').innerHTML =
                    '<form action="{{ route('GG') }}" method="post">' +
                    '@csrf' +
                    '  <div class=" mt-4 d-flex flex-row row justify-content-center">' +
                    ' <div class="mb-3 col-5">' +
                    ' <label for="exampleInputEmail1" class="form-label">ป้ายทะเบียน</label>' +
                    '<input type="text" class="form-control" name="license" />' +
                    '  </div>' +
                    ' <div class="mb-3 col-5">' +
                    '    <label for="exampleInputEmail1" class="form-label">ยี่ห้อ</label>' +
                    '   <input type="text" class="form-control" name="brand" />' +
                    ' </div>' +
                    '<div class="mb-3 col-10">' +
                    ' <label for="exampleInputEmail1" class="form-label">รุ่น</label>' +
                    ' <input type="text" class="form-control" name="model" />' +
                    '   </div>' +
                    ' <div class="mb-3 col-5">' +
                    '<label for="exampleInputEmail1" class="form-label">เจ้าของรถ</label>' +
                    '<input type="text" class="form-control" name="out_name" />' +
                    ' </div>' +
                    ' <div class="mb-3 col-5">' +
                    '   <label for="exampleInputEmail1" class="form-label">เบอร์โทรศัพท์</label>' +
                    ' <input type="text" class="form-control" name="out_tell" />' +
                    ' </div>' +
                    '     </div>' +
                    ' <div class="modal-footer">' +
                    // '<input name="date" type="datetime-local" data-date-format="yyyy-mm-dd" />'+
                    ' <input type="submit" name="submit" class="btn btn-success" value="อนุมัติ" />' +
                    ' <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>' +
                    ' </div>' +
                    '</form>';
            }
        }
    </script>
@endsection
