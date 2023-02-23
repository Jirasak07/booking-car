@extends('layouts.layout')
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
@section('content')
    @include('layouts.header')

    <div class="mt-3">
        @include('driver.header_driver_list')
    </div>
    <div class="container-fluid mt-4">
        <div class="bg-white rounded shadow-xl m-dash p-2">
            
            <div class="table-responsive">
                <table class="table  fw-bold w-100" id="dr_table">
                    <thead class="table-dark table-hover">
                        <tr align="center">
                            <th class="fw-bolder" style="font-size: 16px">ลำดับ</th>
                            <th class="fw-bolder" style="font-size: 16px">ช่วงวันที่</th>
                            <th class="fw-bolder" style="font-size: 16px">รายละเอียด</th>
                            <th class="fw-bolder" style="font-size: 16px">สถานะ</th>
                            <th class="fw-bolder" style="font-size: 16px">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($booking as $item)
                            <tr>
                                <td align="center">{{ $i++ }}</td>
                                <td>
                                    @php
                                        echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                    @endphp
                                </td>
                                <td align="center">
                                    <a class="btn btn-primary btn-sm text-white" onclick="view_detail({{ $item->id }})">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td align="center">
                                    @if ($item->booking_status == 2)
                                        <i
                                            class="fa-regular fa-clock"style="font-size: 14px;color:#fff;background-color:#FF8B13;padding:4px 4px 4px 4px;border-radius:.375rem;"></i>
                                    @elseif ($item->booking_status == 4)
                                        <i class="fa-solid fa-car" style="color: #FF6E31;font-size:24px"></i>
                                    @elseif ($item->booking_status == 5)
                                        <i class="fa-solid fa-square-check" style="color: green;font-size:24px"></i>
                                    @endif
                                </td>
                                <td align="center">
                                    @if ($item->booking_status == 4)
                                        <button class="btn btn-success btn-sm" onclick="complete({{ $item->id }})"
                                            style="font-size: 13px">ดำเนินการเสร็จสิ้น</button>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- View Detail Modal -->
        <div class="modal fade" id="viewdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="staticBackdropLabel">รายละเอียดการจอง</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <strong for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</strong>
                            <div class="col-sm-10">
                                <label type="text" disabled value="" readonly class="form-control-plaintext"
                                    id="user_book" name="user_book">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label">สถานะการจอง</strong>
                            <div class="col-sm-10">
                                <label class="form-control-plaintext" id="status_booking"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <strong for="" class="col-sm-2 col-form-label">ช่วงวันที่</strong>
                            <div class="col-sm-10">
                                <label class="form-control-plaintext" id="date_booking"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <strong for="" class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</strong>
                            <div class="col-sm-8">
                                <label name="" id="detail_car" cols="30" rows="3" readonly
                                    class="form-control-plaintext"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <strong for="" class="col-sm-3 col-form-label">รายละเอียดการจอง</strong>
                            <div class="col-sm-8">
                                <label name="" id="detail_booking" cols="30" disabled
                                    rows="5"value="" readonly class="form-control-plaintext"></label>
                            </div>
                        </div>
                        <div class="row mb-1" id="div-de-can">
                            <strong for="" class="col-sm-3 col-form-label ">สาเหตุการยกเลิก</strong>
                            <div class="col-sm-8">
                                <label name="" id="detail_booking_cancel" cols="30" disabled
                                    rows="5"value="" readonly
                                    class="form-control-plaintext text-red"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dr_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 2
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
        });

        function view_detail(id) {
            var h = window.location.pathname
            var s = h.split('/')
            var status = '';
            var car_detail;
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '/' + s[2] + '/detail/' + id,
                dataType: 'JSON',
                success: function(res) {
                    moment.locale('th');
                    if (res.booking_status == '4') {
                        status = 'กำลังดำเนินการ';
                        $('#status_booking').css("color", "#FFB100");
                        //status.css("color":"red");
                    } else if (res.booking_status == '5') {
                        status = 'ดำเนินการเสร็จสิ้น';
                        $('#status_booking').css("color", "green");
                    } else if (res.booking_status == '2') {
                        status = 'รอดำเนินการ';
                        $('#status_booking').css("color", "#FFB100");
                    }
                    if (res.car_license == '-') {
                        car_detail = '-';
                    } else {
                        car_detail = ' ทะเบียนรถ ' + res.car_license +
                            ' ' + res
                            .car_model;
                    }
                    var detail_booking = res.booking_detail;
                    var s_detail = detail_booking.split('~');
                    if (s_detail.length == 2) {
                        $('#detail_booking_cancel').html(s_detail[1]);
                    } else {
                        $('#div-de-can').html('');
                    }
                    var start = moment(res.booking_start).add(543, 'year').format(
                        'ddd ที่ D MMM YYYY เวลา HH:mm')
                    var end = moment(res.booking_end).add(543, 'year').format('ddd ที่ D MMM YYYY เวลา HH:mm')

                    $('#user_book').html(res.name);
                    $('#status_booking').html(status);
                    $('#date_booking').html(start + ' - ' + end);
                    $('#detail_car').html(car_detail);
                    $('#detail_booking').html(s_detail[0]);
                    $('#viewdetail').modal('toggle');
                }
            });
        }

        function complete(id) {
            var h = window.location.pathname
            var s = h.split('/')
            const data = @json($booking);
            const namecancel = [];

            data.forEach(show => {
                    if (show.id == id) {
                        namecancel.push(show);
                    }
                }),
                (async () => {
                    moment.locale('th')
                    const bstart = moment(JSON.stringify(namecancel[0].booking_start)).format(' D MMM ' + (new Date(
                            namecancel[0].booking_start)
                        .getFullYear() +
                        543) + ' เวลา HH:mm');
                    const bend = moment(JSON.stringify(namecancel[0].booking_end)).format(' D MMM ' + (new Date(
                            namecancel[0].booking_end)
                        .getFullYear() +
                        543) + ' เวลา HH:mm');
                    console.log(namecancel)
                    const {
                        value: text
                    } = await Swal.fire({
                        title: '<h2 class="text-darker">ยืนยันการดำเนินการเสร็จสิ้นใช่หรือไม่</h2>',

                        // inputLabel: '<div>jjj</div>รายการจองของ ' + namecancel[0].name,
                        html: '<div class="col-10" ><div style="width: max-content;">' +
                            '<div style="font-size:1rem;" ><span style="font-weight:800">ระหว่างวันที่ :</span> ' +
                            bstart + ' - ' + bend +
                            '</div><div class="text-left" style="font-size:1rem"><span style="font-weight:800">รายละเอียด : </span>' +
                            namecancel[0].booking_detail + ' </div> </div></div>',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#00b4d8',
                        cancelButtonColor: '#ef476f',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก',

                    }).then((result) => {
                        console.log(result)
                        if (result.isConfirmed) {
                            if (result.value) {
                                $.ajax({
                                    type: 'GET',
                                    url: '/' + s[2] + '/compleace/' + id,
                                    dataType: 'JSON',
                                    success: function(data) {
                                        if (data.status == 'success') {
                                            Swal.fire({
                                                title: 'เสร็จสิ้น',
                                                icon: 'success',
                                                confirmButtonText: 'ตกลง',
                                            }).then((data) => {
                                                window.location.reload();
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
                        }
                    })
                })()
        }
    </script>
@endpush
