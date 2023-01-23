@section('title', 'ข้อมูลการจอง')
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="" id="re">

        <div class="container-fulid mx-3 ">
            <div class="container-md pt-3 pb-3 ">
                <div class=" card shadow-table p-3  ">
                    <table id="tablerequest" class="display responsive nowrap " style="width:100%;font-size:0.8em">
                        <thead class="table-dark">
                            <tr>
                                <th class="d-grid d-sm-none" style="max-width: 20px"></th>
                                <th style="max-width: 30px">ลำดับ</th>
                                <th>ผู้จอง</th>
                                <th>วันเวลาเริ่มต้น</th>
                                <th>วันเวลาสิ้นสุด</th>
                                <th>รายละเอียด</th>
                                <th>จัดการ</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($booking as $bookings)
                                @if ($bookings['booking_status'] == 1)
                                    <tr>
                                        <td class="control d-grid d-sm-none"></td>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $bookings['name'] }}</td>

                                        <td class="text-truncate" style="max-width: 250px">
                                            {{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($bookings['booking_start'])) }}
                                        </td>
                                        <td class="text-truncate" style="max-width: 300px">
                                            {{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($bookings['booking_end'])) }}
                                        </td>
                                        <td>{{ $bookings['booking_detail'] }}</td>
                                        <td>
                                            <div class="btn btn-success btn-sm" onclick="modal({{ $bookings['id'] }})"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                อนุมัติ</div>
                                            <a class="text-white btn btn-danger btn-sm "
                                                onclick="alertCancel({{ $bookings['id'] }})">ยกเลิกคำขอ</a>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                        <div class="d-grid  justify-content-center row">
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
                                        <form method="POST" action="{{ route('update') }}"
                                            class="d-flex flex-column align-items-center">
                                            @csrf
                                            <input type="hidden" id="idform" name="id_form">
                                            <input type="hidden" name="type" value="1">
                                            <div class=" mt-4">
                                                <label for="selectcar">เลือกรถที่ต้องการใช้</label>
                                                <select name="car_id" id="selectcar" class="rounded form-control" required
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
                                                    required style="width: 250px;  border:1px solid #6673af30 ">
                                                    @foreach ($driver as $dv)
                                                        <option value="{{ $dv['id'] }}">{{ $dv['driver_fullname'] }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>



                                            <div class="d-flex align-self-end justify-content-end w-100 mt-4 ">
                                                <input type="submit" value="บันทึก"
                                                    class="btn btn-sm btn-success w-25" />
                                                <button type="button" class="btn btn-sm btn-outline-danger w-25 "
                                                    data-bs-dismiss="modal" aria-label="Close">ปิด</button>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="tab-pane pt-5" id="tab2">

                                        <div class="card card-body">
                                            <form method="POST" action="{{ route('updateout') }}">
                                                @csrf
                                                <input type="hidden" id="idform2" name="id_form">
                                                <input type="hidden" name="type" value="2">
                                                <div class="form-group row mt-2 d-flex flex-column flex-md-row ">
                                                    <div class="col-6 "> <label for="out-model">ยี่ห้อ</label>
                                                        <input type="text" id="out-model" name="brand" class="form-control">
                                                    </div>

                                                    <div class="col-6 ">
                                                        <label for="out-license"> ป้ายทะเบียน </label> <input name="car_out_license"
                                                            type="text" id="out-license" class="form-control">
                                                    </div>
                                                    <div class="col-12 "> <label for="out-model">รายละเอียด/รุ่น</label>
                                                        <input type="text" id="out-model" name="car_out_model" class="form-control">
                                                    </div>
                                                    <div class="col-12 "> <label for="out-driver">คนขับ</label>
                                                        <input type="text" id="out-driver" name="car_out_driver" class="form-control">
                                                    </div>
                                                    <div class="col-12 ">
                                                        <label for="out-own"> เจ้าของรถ </label> <input type="text"
                                                            id="out-own" class="form-control" name="owner">
                                                    </div>
                                                    <div class="col-12 "> <label for="out-tell"> เบอร์โทรติดต่อ
                                                        </label> <input type="text" id="out-tell"
                                                            class="form-control" name="car_out_tel" />
                                                    </div>

                                                </div>
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button class="btn btn-sm btn-success w-25" type="submit"> บันทึก </button>
                                                    <button
                                                        type="button" class="btn btn-sm btn-outline-danger w-25 " data -
                                                        bs - dismiss="modal" aria - label="Close"
                                                        onclick="open_modal()"> ปิด </button>
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
        </div>
    </div>

    </div>


    </div>
    @push('js')
        <script src="https://momentjs.com/downloads/moment-with-locales.js">
            < /scrip> <
            script src = "https://code.jquery.com/jquery-3.5.1.js" >
        </script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

        <script>
            $('.nav-tabs a').on('click', function(e) {
                e.preventDefault()
                $(this).tab('show')
            });

            $(document).ready(function() {
                $('#tablerequest').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 0,
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.hidden ?
                                        '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' +
                                        col.columnIndex + '">' +
                                        '<td>' + col.title + ':' + '</td> ' +
                                        '<td>' + col.data + '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ?
                                    $('<table/>').append(data) :
                                    false;
                            }
                        }
                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 10001,
                            targets: 4
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
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
            });

            function modal(val) {
                // document.getElementById('')
                const data = @json($booking);
                const bookdata = [];
                moment.locale('th');
                const start = [];
                const end = [];
                const detail = [];
                data.forEach(showBooking => {
                    if (showBooking.id == val) {
                        start.push(showBooking.booking_start);

                        end.push(showBooking.booking_end);
                        detail.push(showBooking.booking_detail);
                    }
                });
                const bookstart = moment(JSON.stringify(start[0])).format('ddd ที่ D MMM ' + (new Date(start[0]).getFullYear() +
                    543) + ' เวลา HH:mm นาที');
                const bookend = moment(JSON.stringify(end[0])).format('ddd ที่ D MMM ' + (new Date(end[0]).getFullYear() +
                    543) + ' เวลา HH:mm นาที');
                // console.log(typeof(bookstart));
                // alert(bookstart);
                // const da = moment().format('D-MM-YYYY');
                // console.log(da);
                document.getElementById('start_date').innerHTML = bookstart;
                document.getElementById('end_date').innerHTML = bookend;
                document.getElementById('detail').innerHTML = detail[0];
                document.getElementById('idform').value = val;
                document.getElementById('idform2').value = val;
            }
        </script>
        <script>
            function alertCancel(id) {
                //alert(id)
                Swal.fire({
                    //title: 'Are you sure?',
                    text: "คุณต้องการยกเลิกการจองใช่หรือไม่!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'GET',
                            url: '/admin/cancel/' + id,
                            dataType: 'JSON',
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire({
                                        title: 'เสร็จสิ้น',
                                        icon: 'success',
                                        confirmButtonText: 'ok',
                                    }).then((data) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        icon: 'error',
                                    })
                                }
                            },
                        });
                    }
                })
            }
        </script>
    @endpush
@endsection
