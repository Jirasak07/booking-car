@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 mt-2 ">
        <div class=" shadow-table ">

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
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($booking as $bookings)
                        @if ($bookings['booking_status'] == 1)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $bookings['username'] }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($bookings['booking_start'])) }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($bookings['booking_end'])) }}</td>
                                <td>{{ $bookings['booking_detail'] }}</td>
                                <td>
                                    <div class="btn btn-success btn-sm" onclick="modal({{ $bookings['id'] }})"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        อนุมัติ</div>
                                    <a class="text-white btn btn-danger btn-sm "
                                        href="{{ route('cancle', $bookings['id']) }}">ยกเลิกคำขอ</a>
                                </td>
                            </tr>
                        @endif
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
                            <label class=" ml-2" style="font-size: 80%;color:#630606;" for=""
                                id="start_date"></label>
                        </div>
                        <div class="col-6">
                            <label for="" class="form-label" style="line-height:50%">วันเวลาที่สิ้นสุด</label>
                            </br>
                            <label class=" ml-2" style="font-size: 80%;color:#630606;" for=""
                                id="end_date"></label>
                        </div>
                        <div class="col-12 ">
                            <label for="" class="form-label" style="line-height:50%">รายละเอียดการจอง</label>
                            </br>
                            <label class=" ml-2" style="font-size: 80%;color:#630606;" for=""
                                id="detail">11012543</label>
                        </div>
                    </div>
                    <div class="d-grid  justify-content-center row gap">
                        <div class="container">
                            <ul class="nav nav-tabs d-flex justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab1">ใช้รถภายใน</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab2">ใช้รถภายนอก</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <form method="POST" action="{{ route('update') }}" class="d-flex flex-column align-items-center">
                                        @csrf
                                        <input type="hidden" id="idform" name="id_form">
                                        <input type="hidden" name="type" value="1">
                                        <div class=" mt-4">
                                            <label for="selectcar">เลือกรถที่ต้องการใช้</label>
                                            <select name="car_id" id="selectcar" class="rounded form-control"
                                                style="width: 250px; border:1px solid #6673af30 ">
                                                @foreach ($car as $cars)
                                                    <option value="{{ $cars['id'] }}">{{ $cars['car_model'] }}
                                                        {{ $cars['car_license'] }} </option>
                                                @endforeach


                                            </select>
                                        </div>
                                        <div>
                                            <label for="selectdriver">เลือกพนักงานขับรถ</label>
                                            <select name="driver_id" id=" selectdriver" class="rounded form-control"
                                                style="width: 250px;  border:1px solid #6673af30 ">
                                                @foreach ($driver as $dv)
                                                    <option value="{{ $dv['id'] }}">{{ $dv['driver_fullname'] }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>



                                        <div class="d-flex align-self-end justify-content-end w-100 mt-4 ">
                                            <input type="submit" value="บันทึก" class="btn btn-sm btn-success w-25" />
                                            <button type="button" class="btn btn-sm btn-outline-danger w-25 "
                                                data-bs-dismiss="modal" aria-label="Close">ปิด</button>
                                        </div>

                                    </form>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <form action="">
                                        @csrf
                                        <div class="form-group row mt-2 d-flex flex-column flex-md-row ">
                                            <div class="col-12 col-md-6"> <label for="out-model">รถ</label>
                                                <input type="text" id="out-model" class="form-control">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="out-license">ป้ายทะเบียน</label>
                                                <input type="text" id="out-license" class="form-control">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="out-own">เจ้าของรถ</label>
                                                <input type="text" id="out-own" class="form-control">
                                            </div>
                                            <div class="col-12 col-md-6"> <label for="out-tell">เบอร์โทรติดต่อ</label>
                                                <input type="text" id="out-tell" class="form-control">
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <div class="btn btn-sm btn-success w-25">บันทึก</div>
                                            <button type="button" class="btn btn-sm btn-outline-danger w-25 "
                                                data-bs-dismiss="modal" aria-label="Close">ปิด</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script>
        $('.nav-tabs a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        })

        function modal(val) {
            // document.getElementById('')
            const data = @json($booking);
            moment.locale('th');

            const start = data[val - 1];
            const bookstart = moment(start.booking_start).add(543, 'year').format('ddd ที่ D MMM YY เวลา HH:mm นาที');
            const bookend = moment(start.booking_end).add(543, 'year').format('ddd ที่ D MMM YY เวลา HH:mm นาที');
            // console.log(typeof(bookstart));
            // alert(bookstart);
            // const da = moment().format('D-MM-YYYY');
            // console.log(da);
            document.getElementById('start_date').innerHTML = bookstart;
            document.getElementById('end_date').innerHTML = bookend;
            document.getElementById('detail').innerHTML = start.booking_detail;
            document.getElementById('idform').value = val;
            // {{ thaidate('l j F Y เวลา G:i', strtotime($bookings['booking_start'])) }}
        }
    </script>
@endsection
